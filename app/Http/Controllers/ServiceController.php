<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('partner_id', auth()->id())->get();
        return view('partner.services.index', compact('services'));
    }

    public function create()
    {
        return view('partner.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:500',
            'thumbnail' => 'required|image|max:2048',
        ]);

        try {
            $uploadedFile = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'service_thumbnails'
            ]);

            // Tambahkan 5% ke harga
            $priceWithFee = $request->price * 1.05;

            Service::create([
                'partner_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'price' => $priceWithFee,
                'original_price' => $request->price, // Simpan harga asli
                'thumbnail' => $uploadedFile->getSecurePath(),
                'status' => 'pending'
            ]);

            return redirect()->route('partner.services.index')->with('success', 'Service added successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add service: '.$e->getMessage());
        }
    }

    public function show(Service $service)
    {
        return view('partner.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('partner.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:500',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        try {
            // Tambahkan 5% ke harga
            $priceWithFee = $request->price * 1.05;

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $priceWithFee,
                'original_price' => $request->price, // Simpan harga asli
            ];

            if ($request->hasFile('thumbnail')) {
                $uploadedFile = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'service_thumbnails'
                ]);
                $data['thumbnail'] = $uploadedFile->getSecurePath();
            }

            $service->update($data);

            return redirect()->route('partner.services.index')->with('success', 'Service updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update service: '.$e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('partner.services.index')->with('success', 'Service deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete service: '.$e->getMessage());
        }
    }
}