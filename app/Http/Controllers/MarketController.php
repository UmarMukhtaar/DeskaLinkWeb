<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Service;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']); // Hanya index yang bisa diakses tanpa login
    }
    
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'services');
        
        $services = [];
        $designs = [];
        
        if ($activeTab === 'services') {
            $services = Service::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $designs = Design::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('client.market', [
            'activeTab' => $activeTab,
            'services' => $services,
            'designs' => $designs,
        ]);
    }
}