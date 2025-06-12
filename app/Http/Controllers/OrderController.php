<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'client') {
            $requestedItems = OrderItem::where('client_id', $user->id)
                ->where('status', 'pending')
                ->with(['order', 'partner'])
                ->get();
                
            $processingItems = OrderItem::where('client_id', $user->id)
                ->where('status', 'processing')
                ->with(['order', 'partner'])
                ->get();
                
            $completedItems = OrderItem::where('client_id', $user->id)
                ->where('status', 'delivered')
                ->with(['order', 'partner'])
                ->get();
                
            $rejectedItems = OrderItem::where('client_id', $user->id)
                ->where('status', 'canceled')
                ->whereNotNull('rejection_reason')
                ->with(['order', 'partner'])
                ->get();
        } else {
            $requestedItems = OrderItem::where('partner_id', $user->id)
                ->where('status', 'pending')
                ->with(['order', 'client'])
                ->get();
                
            $processingItems = OrderItem::where('partner_id', $user->id)
                ->where('status', 'processing')
                ->with(['order', 'client'])
                ->get();
                
            $completedItems = OrderItem::where('partner_id', $user->id)
                ->where('status', 'delivered')
                ->with(['order', 'client'])
                ->get();
                
            $rejectedItems = OrderItem::where('partner_id', $user->id)
                ->where('status', 'canceled')
                ->whereNotNull('rejection_reason')
                ->with(['order', 'client'])
                ->get();
        }
        
        return view('orders.index', [
            'requestedItems' => $requestedItems,
            'processingItems' => $processingItems,
            'completedItems' => $completedItems,
            'rejectedItems' => $rejectedItems,
            'role' => $user->role
        ]);
    }

    public function cancelItem(OrderItem $orderItem)
    {
        if (Auth::id() !== $orderItem->client_id) {
            abort(403);
        }
        
        try {
            DB::transaction(function() use ($orderItem) {
                // Refund client
                $client = $orderItem->client;
                $client->balance += $orderItem->price;
                $client->save();
                
                // Update item status
                $orderItem->status = 'canceled';
                $orderItem->save();
                
                // Check if all items in order are canceled
                $allCanceled = $orderItem->order->items()
                    ->where('status', '!=', 'canceled')
                    ->doesntExist();
                    
                if ($allCanceled) {
                    $orderItem->order->status = 'canceled';
                    $orderItem->order->save();
                }
            });
            
            return back()->with('success', 'Item pesanan berhasil dibatalkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan item pesanan');
        }
    }

    public function rejectItem(Request $request, OrderItem $orderItem)
    {
        // Validate authorization and order status
        if (Auth::id() !== $orderItem->partner_id || !in_array($orderItem->status, ['pending', 'processing'])) {
            abort(403, 'Unauthorized or invalid order status');
        }
        // if (Auth::id() !== $orderItem->partner_id || $orderItem->status !== 'pending') {
        //     abort(403, 'Unauthorized or invalid order status');
        // }
        
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);
        
        try {
            DB::transaction(function() use ($orderItem, $request) {
                // Only refund if payment was already deducted
                if ($orderItem->order->payment_status === 'paid') {
                    $client = $orderItem->client;
                    $client->balance += $orderItem->price;
                    $client->save();
                    
                    // Log the refund
                    Log::info('Order item rejected, refund issued', [
                        'order_item_id' => $orderItem->id,
                        'client_id' => $client->id,
                        'amount' => $orderItem->price,
                    ]);
                }
                
                // Update item status
                $orderItem->update([
                    'status' => 'canceled',
                    'rejection_reason' => $request->rejection_reason,
                    'canceled_at' => now(),
                ]);
                
                // Check if all items in order are canceled
                $allCanceled = $orderItem->order->items()
                    ->where('status', '!=', 'canceled')
                    ->doesntExist();
                    
                if ($allCanceled) {
                    $orderItem->order->update(['status' => 'canceled']);
                }
            });
            
            return redirect()->back()
                ->with('success', 'Item pesanan berhasil ditolak')
                ->with('tab', 'requested');
        } catch (\Exception $e) {
            Log::error('Failed to reject order item', [
                'order_item_id' => $orderItem->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->with('error', 'Gagal menolak item pesanan: ' . $e->getMessage());
        }
    }

    public function acceptItem(OrderItem $orderItem)
    {
        if (Auth::id() !== $orderItem->partner_id) {
            abort(403);
        }
        
        try {
            $orderItem->update(['status' => 'processing']);
            return back()->with('success', 'Item pesanan berhasil diterima');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menerima item pesanan');
        }
    }

    public function showSubmitForm(OrderItem $orderItem)
    {
        if (Auth::id() !== $orderItem->partner_id || $orderItem->status !== 'processing') {
            abort(403);
        }
        
        return view('orders.submit', [
            'orderItem' => $orderItem
        ]);
    }

    public function submitResult(Request $request, OrderItem $orderItem)
    {
        if (Auth::id() !== $orderItem->partner_id || $orderItem->status !== 'processing') {
            abort(403, 'Unauthorized or invalid order status');
        }

        $request->validate([
            'result_url' => 'required|url'
        ]);

        try {
            DB::transaction(function() use ($orderItem, $request) {
                // Logging awal
                Log::debug('Submitting result for order item', [
                    'order_item_id' => $orderItem->id,
                    'partner_id' => $orderItem->partner_id,
                    'price' => $orderItem->price,
                ]);

                // Update order item
                $orderItem->update([
                    'status' => 'delivered',
                    'result_url' => $request->result_url
                ]);
                Log::debug('Order item updated to delivered');

                // Calculate amount with 5% admin fee
                $partnerAmount = $orderItem->price / 1.05;
                $adminFee = $orderItem->price - $partnerAmount;

                Log::debug('Fee calculation', [
                    'partnerAmount' => $partnerAmount,
                    'adminFee' => $adminFee,
                ]);

                // Transfer funds
                $orderItem->partner->balance += $partnerAmount;
                $orderItem->partner->save();
                Log::debug('Partner balance updated', [
                    'new_balance' => $orderItem->partner->balance,
                ]);

                // Add admin fee to admin (user with id 1)
                $admin = User::find(1);
                if ($admin) {
                    $admin->balance += $adminFee;
                    $admin->save();
                    Log::debug('Admin balance updated', [
                        'admin_id' => 1,
                        'admin_balance' => $admin->balance,
                    ]);
                }

                // Check if all items in order are delivered
                $allDelivered = $orderItem->order->items()
                    ->where('status', '!=', 'delivered')
                    ->doesntExist();

                Log::debug('Check all items delivered', ['allDelivered' => $allDelivered]);

                if ($allDelivered) {
                    $orderItem->order->update(['status' => 'completed']);
                    Log::debug('Order marked as completed', ['order_id' => $orderItem->order_id]);
                }
            });

            return redirect()->route('partner.orders.index', ['tab' => 'processing'])
                ->with('success', 'Hasil berhasil dikirim');
        } catch (\Exception $e) {
            Log::error('Error saat submitResult', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Gagal mengirim hasil');
        }
    }

}