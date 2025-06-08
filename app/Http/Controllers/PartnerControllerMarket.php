<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PartnerControllerMarket extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $partner)
    {
        // Only allow viewing partner profiles
        if ($partner->role !== 'partner') {
            abort(404);
        }

        $services = Service::where('partner_id', $partner->id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $designs = Design::where('partner_id', $partner->id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $serviceCount = $services->count();
        $designCount = $designs->count();

        return view('client.partner.show', [
            'partner' => $partner,
            'services' => $services,
            'designs' => $designs,
            'serviceCount' => $serviceCount,
            'designCount' => $designCount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
