<?php

// app/Http/Controllers/CheckoutController.php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Design;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCheckout()
    {
        $cartItems = Auth::user()->cartItems;
        $totalPrice = $cartItems->sum('price');
        
        return view('client.checkout.show', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function directCheckout(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'item_type' => 'required|in:service,design',
        ]);
        
        $user = Auth::user();
        
        try {
            // Get item details
            if ($request->item_type === 'service') {
                $item = Service::findOrFail($request->item_id);
            } else {
                $item = Design::findOrFail($request->item_id);
            }
            
            // Check balance
            if ($user->balance < $item->price) {
                return back()->with('error', 'Saldo tidak cukup untuk membeli item ini');
            }
            
            return redirect()->route('client.checkout.direct_notes', [
                'items' => [[
                    'item_id' => $item->id,
                    'item_type' => $request->item_type,
                    'title' => $item->title,
                    'price' => $item->price,
                    'partner_id' => $item->partner_id,
                ]],
                'total' => $item->price
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses checkout');
        }
    }

    public function showNotes(Request $request)
    {
        $items = $request->input('items');
        $total = $request->input('total');
        
        return view('client.checkout.notes', [
            'items' => $items,
            'totalPrice' => $total
        ]);
    }

    public function showDirectNotes(Request $request)
    {
        $items = $request->input('items');
        $total = $request->input('total');
        
        return view('client.checkout.direct_notes', [
            'items' => $items,
            'totalPrice' => $total
        ]);
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems;
        $totalPrice = $cartItems->sum('price');
        
        // Check balance
        if ($user->balance < $totalPrice) {
            return back()->with('error', 'Saldo tidak cukup untuk melakukan checkout');
        }
        
        try {
            // Prepare items for notes page
            $items = $cartItems->map(function($item) {
                return [
                    'item_id' => $item->item_id,
                    'item_type' => $item->item_type,
                    'title' => $item->title,
                    'price' => $item->price,
                    'partner_id' => $item->partner_id,
                ];
            })->toArray();
            
            return redirect()->route('client.checkout.notes', [
                'items' => $items,
                'total' => $totalPrice
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses checkout');
        }
    }

    public function saveNotes(Request $request)
    {
        $user = Auth::user();
        $items = $request->input('items');
        $notes = $request->input('notes', []);
        $totalPrice = $request->input('total');
        
        // Check balance again
        if ($user->balance < $totalPrice) {
            return back()->with('error', 'Saldo tidak cukup untuk melakukan checkout');
        }
        
        try {
            DB::transaction(function() use ($user, $items, $notes, $totalPrice, $request) {
                // Create order
                $order = new Order([
                    'client_id' => $user->id,
                    'total_amount' => $totalPrice,
                    'status' => 'held',
                ]);
                $order->save();
                
                // Create order items
                foreach ($items as $index => $item) {
                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'item_id' => $item['item_id'],
                        'item_type' => $item['item_type'],
                        'title' => $item['title'],
                        'price' => $item['price'],
                        'partner_id' => $item['partner_id'],
                        'client_id' => $user->id,
                        'status' => 'pending',
                        'note' => $notes[$index] ?? null,
                    ]);
                    $orderItem->save();
                }
                
                // Deduct balance
                $user->balance -= $totalPrice;
                $user->save();
                
                // Clear cart if coming from cart
                if ($request->has('from_cart')) {
                    $user->cartItems()->delete();
                }
            });
            
            return redirect()->route('client.checkout.success');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pesanan');
        }
    }

    public function saveDirectNotes(Request $request)
    {
        $user = Auth::user();
        $items = $request->input('items');
        $notes = $request->input('notes', []);
        $totalPrice = $request->input('total');
        
        // Check balance again
        if ($user->balance < $totalPrice) {
            return back()->with('error', 'Saldo tidak cukup untuk melakukan checkout');
        }
        
        try {
            DB::transaction(function() use ($user, $items, $notes, $totalPrice, $request) {
                // Create order
                $order = new Order([
                    'client_id' => $user->id,
                    'total_amount' => $totalPrice,
                    'status' => 'held',
                ]);
                $order->save();
                
                // Create order items
                foreach ($items as $index => $item) {
                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'item_id' => $item['item_id'],
                        'item_type' => $item['item_type'],
                        'title' => $item['title'],
                        'price' => $item['price'],
                        'partner_id' => $item['partner_id'],
                        'client_id' => $user->id,
                        'status' => 'pending',
                        'note' => $notes[$index] ?? null,
                    ]);
                    $orderItem->save();
                }
                
                // Deduct balance
                $user->balance -= $totalPrice;
                $user->save();
            });
            
            return redirect()->route('client.checkout.success');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pesanan');
        }
    }

    public function success()
    {
        return view('client.checkout.success');
    }
}