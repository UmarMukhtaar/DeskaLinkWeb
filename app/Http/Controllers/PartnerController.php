<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Design;
use App\Models\OrderItem;

class PartnerController extends Controller
{
    public function dashboard()
{
    $user = auth()->user();
    
    // Content stats
    $approvedServices = Service::where('partner_id', $user->id)
        ->where('status', 'approved')
        ->count();
    $approvedDesigns = Design::where('partner_id', $user->id)
        ->where('status', 'approved')
        ->count();
    
    $pendingServices = Service::where('partner_id', $user->id)
        ->where('status', 'pending')
        ->count();
    $pendingDesigns = Design::where('partner_id', $user->id)
        ->where('status', 'pending')
        ->count();
    
    // Order stats
    $orderCount = OrderItem::where('partner_id', $user->id)->count();
    // $totalRevenue = OrderItem::where('partner_id', $user->id)
    //     ->where('status', 'delivered')
    //     ->sum('price');
    
    $orderItems = OrderItem::where('partner_id', $user->id)
    ->where('status', 'delivered')
    ->get();

    $totalRevenue = $orderItems->sum(function ($item) {
        return $item->price / 1.05;
    });
    
    // Recent content
    $recentServices = collect(
        Service::where('partner_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($service) {
                return [
                    'id' => $service->id,
                    'type' => 'service',
                    'title' => $service->title,
                    'price' => $service->price,
                    'status' => $service->status,
                    'rejection_reason' => $service->rejection_reason,
                    'created_at' => $service->created_at
                ];
            })
            ->values()
            ->all()
    );

    $recentDesigns = collect(
        Design::where('partner_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($design) {
                return [
                    'id' => $design->id,
                    'type' => 'design',
                    'title' => $design->title,
                    'price' => $design->price,
                    'status' => $design->status,
                    'rejection_reason' => $design->rejection_reason,
                    'created_at' => $design->created_at
                ];
            })
            ->values()
            ->all()
    );

    $recentContent = $recentServices->merge($recentDesigns)
        ->sortByDesc('created_at')
        ->take(5);
    
    // Recent orders
    $recentOrders = OrderItem::with(['client'])
        ->where('partner_id', $user->id)
        ->latest()
        ->take(5)
        ->get();
    
    // Notifications
    $notifications = collect();
    
    // Rejected content notifications
    $rejectedServices = Service::where('partner_id', $user->id)
        ->where('status', 'banned')
        ->whereNotNull('rejection_reason')
        ->latest()
        ->take(2)
        ->get()
        ->map(function($service) {
            return [
                'type' => 'rejection',
                'title' => 'Jasa Ditolak: ' . $service->title,
                'message' => $service->rejection_reason,
                'time' => $service->updated_at->diffForHumans()
            ];
        });
    
    $rejectedDesigns = Design::where('partner_id', $user->id)
        ->where('status', 'banned')
        ->whereNotNull('rejection_reason')
        ->latest()
        ->take(2)
        ->get()
        ->map(function($design) {
            return [
                'type' => 'rejection',
                'title' => 'Desain Ditolak: ' . $design->title,
                'message' => $design->rejection_reason,
                'time' => $design->updated_at->diffForHumans()
            ];
        });
    
    // Pending orders notifications
    $pendingOrders = OrderItem::where('partner_id', $user->id)
        ->where('status', 'pending')
        ->latest()
        ->take(2)
        ->get()
        ->map(function($order) {
            return [
                'type' => 'order',
                'title' => 'Pesanan Baru: ' . $order->title,
                'message' => 'Menunggu konfirmasi Anda',
                'time' => $order->created_at->diffForHumans()
            ];
        });
    
    $notifications = $notifications->merge($rejectedServices)
        ->merge($rejectedDesigns)
        ->merge($pendingOrders)
        ->sortByDesc('time')
        ->take(5);
    
    return view('partner.dashboard', [
        'stats' => [
            'approved_content' => $approvedServices + $approvedDesigns,
            'pending_content' => $pendingServices + $pendingDesigns,
            'order_count' => $orderCount,
            'total_revenue' => $totalRevenue,
        ],
        'recentContent' => $recentContent,
        'recentOrders' => $recentOrders,
        'notifications' => $notifications,
    ]);
}
}
