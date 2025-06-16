<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Design;
use App\Models\Service;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // User Management Methods
    public function userManagement(Request $request)
    {
        $query = User::query();

        // Filter hanya untuk role 'client' dan 'partner'
        $query->whereIn('role', ['client', 'partner']);

        // Pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                ->orWhere('full_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter berdasarkan role (kalau disediakan oleh user)
        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        return view('admin.user_management_page', compact('users'));
    }

    public function toggleBan(User $user)
    {
        try {
            $newStatus = $user->status === 'active' ? 'banned' : 'active';
            $user->status = $newStatus;
            $user->save();
            
            $statusText = $newStatus === 'banned' ? 'diblokir' : 'diaktifkan';
            return back()->with('success', "Status pengguna berhasil $statusText");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status pengguna');
        }
    }

    public function destroyUser(User $user)
    {
        try {
            DB::transaction(function() use ($user) {
                $user->designs()->delete();
                $user->services()->delete();
                $user->delete();
            });
            
            return back()->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    // Content Management Methods
    public function contentManagement(Request $request)
    {
        $services = Service::with('partner')
            ->whereIn('status', ['pending', 'approved', 'banned'])
            ->latest()
            ->paginate(10, ['*'], 'services_page');
            
        $designs = Design::with('partner')
            ->whereIn('status', ['pending', 'approved', 'banned'])
            ->latest()
            ->paginate(10, ['*'], 'designs_page');
            
        return view('admin.content_management_page', compact('services', 'designs'));
    }

    public function approveContent(Request $request, $type, $id)
    {
        try {
            $model = $type === 'service' ? Service::findOrFail($id) : Design::findOrFail($id);
            
            $model->status = 'approved';
            if (!empty($model->rejection_reason)) {
                $model->rejection_reason = null;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil disetujui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menyetujui konten: ' . $e->getMessage()
            ]);
        }
    }

    public function rejectContent(Request $request, $type, $id)
    {
        try {
            $request->validate(['reason' => 'required|string']);
            
            $model = $type === 'service' ? Service::findOrFail($id) : Design::findOrFail($id);
            $model->status = 'banned';
            $model->rejection_reason = $request->reason;
            $model->save();
            
            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menolak konten: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteContent($type, $id)
    {
        try {
            $model = $type === 'service' ? Service::findOrFail($id) : Design::findOrFail($id);
            $model->delete();
            
            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menghapus konten: ' . $e->getMessage()
            ]);
        }
    }

    public function dashboard()
    {
        // User stats
        $clientCount = User::where('role', 'client')->count();
        $partnerCount = User::where('role', 'partner')->count();
        
        // Content stats
        $serviceCount = Service::where('status', 'approved')->count();
        $designCount = Design::where('status', 'approved')->count();
        
        // Transaction stats
        //$orderCount = Order::count();
        $orderCount = OrderItem::whereIn('status', ['processing', 'delivered'])->count();

        //$totalTransactions = OrderItem::sum('price');
        $totalTransactions = OrderItem::whereIn('status', ['processing', 'delivered'])
            ->sum('price');

        //$adminRevenue = $totalTransactions * 0.05; // 5% commission
        $orderItems = OrderItem::where('status', 'delivered')->get();
        $adminRevenue = $orderItems->sum(function ($item) {
            return $item->price * (5 / 105); // 5% dari harga kotor
        });

        // Recent pending content
        $pendingServices = collect(
            Service::with('partner')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($service) {
                    return [
                        'id' => $service->id,
                        'type' => 'service',
                        'title' => $service->title,
                        'partner_name' => $service->partner->full_name,
                        'price' => $service->price,
                        'created_at' => $service->created_at
                    ];
                })
                ->values()
                ->all() // ->all() menghasilkan array → dibungkus lagi dengan collect()
        );

        $pendingDesigns = collect(
            Design::with('partner')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($design) {
                    return [
                        'id' => $design->id,
                        'type' => 'design',
                        'title' => $design->title,
                        'partner_name' => $design->partner->full_name,
                        'price' => $design->price,
                        'created_at' => $design->created_at
                    ];
                })
                ->values()
                ->all()
        );

        
        $pendingContent = $pendingServices->merge($pendingDesigns)
            ->sortByDesc('created_at')
            ->take(5);
        
        // Recent orders
        $recentOrders = OrderItem::with(['client', 'partner'])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent users
        $recentUsers = User::where('role', '!=', 'admin')
            ->latest()
            ->take(5)
            ->get();
        
        // Transaction data for chart (last 6 months)
        $transactionData = [];
        $transactionLabels = [];
        $transactionRevenueData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $revenue = OrderItem::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->sum('price');
            
            $transactionData[] = $count;
            $transactionRevenueData[] = $revenue;
            $transactionLabels[] = $month->format('M Y');
        }
        
        // User role distribution data
        $userRoleData = [
            User::where('role', 'client')->count(),
            User::where('role', 'partner')->count()
        ];
        
        // Content status data
        $contentStatusData = [
            Service::where('status', 'pending')->count() + Design::where('status', 'pending')->count(),
            Service::where('status', 'approved')->count() + Design::where('status', 'approved')->count(),
            Service::where('status', 'banned')->count() + Design::where('status', 'banned')->count(),
        ];
        
        return view('admin.dashboard', [
            'stats' => [
                'total_users' => $clientCount + $partnerCount,
                'client_count' => $clientCount,
                'partner_count' => $partnerCount,
                'total_content' => $serviceCount + $designCount,
                'service_count' => $serviceCount,
                'design_count' => $designCount,
                'order_count' => $orderCount,
                'total_transactions' => $totalTransactions,
                'admin_revenue' => $adminRevenue,
            ],
            'pendingContent' => $pendingContent,
            'recentOrders' => $recentOrders,
            'recentUsers' => $recentUsers,
            'transactionLabels' => $transactionLabels,
            'transactionData' => $transactionData,
            'transactionRevenueData' => $transactionRevenueData,
            'userRoleData' => $userRoleData,
            'contentStatusData' => $contentStatusData,
        ]);
    }
}