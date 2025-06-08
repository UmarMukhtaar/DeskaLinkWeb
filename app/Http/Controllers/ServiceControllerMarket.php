<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Service;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceControllerMarket extends Controller
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
    public function show(Service $service)
    {
        $partner = $service->partner;
        $serviceCount = Service::where('partner_id', $partner->id)
            ->where('status', 'approved')
            ->count();
        $designCount = Design::where('partner_id', $partner->id)
            ->where('status', 'approved')
            ->count();

        return view('client.service.show', [
            'service' => $service,
            'partner' => $partner,
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
