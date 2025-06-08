<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designs = Design::where('partner_id', Auth::id())
            ->latest()
            ->get();

        return view('partner.designs.index', compact('designs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partner.designs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:500',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'previews.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload thumbnail to Cloudinary
            $thumbnailUpload = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'designs/thumbnails'
            ]);
            $thumbnailUrl = $thumbnailUpload->getSecurePath();

            // Upload preview images if any
            $previewUrls = [];
            if ($request->hasFile('previews')) {
                foreach ($request->file('previews') as $preview) {
                    $upload = Cloudinary::upload($preview->getRealPath(), [
                        'folder' => 'designs/previews'
                    ]);
                    $previewUrls[] = $upload->getSecurePath();
                }
            }

            // Calculate price with 5% fee
            $priceWithFee = $request->price * 1.05;

            // Create new design
            Design::create([
                'partner_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'price' => $priceWithFee,
                'original_price' => $request->price,
                'status' => 'pending',
                'thumbnail' => $thumbnailUrl,
                'previews' => !empty($previewUrls) ? $previewUrls : null,
            ]);

            return redirect()->route('partner.designs.index')
                ->with('success', 'Design created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create design: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Design $design)
    {
        // Check if the design belongs to the authenticated partner
        if ($design->partner_id !== Auth::id()) {
            abort(403);
        }

        return view('partner.designs.show', compact('design'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Design $design)
    {
        // Check if the design belongs to the authenticated partner
        if ($design->partner_id !== Auth::id()) {
            abort(403);
        }

        return view('partner.designs.edit', compact('design'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Design $design)
    {
        // Check if the design belongs to the authenticated partner
        if ($design->partner_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'previews.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Calculate price with 5% fee
            $priceWithFee = $request->price * 1.05;
            
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $priceWithFee,
                'original_price' => $request->price,
            ];

            // Handle thumbnail update
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail from Cloudinary if needed
                // Cloudinary doesn't require manual deletion as it has automatic asset management
                
                // Upload new thumbnail
                $thumbnailUpload = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                    'folder' => 'designs/thumbnails'
                ]);
                $data['thumbnail'] = $thumbnailUpload->getSecurePath();
            }

            // Handle preview images
            $previewUrls = $design->previews ?? [];
            
            // Remove deleted previews
            if ($request->has('removed_previews')) {
                $previewsToRemove = $request->removed_previews;
                $previewUrls = array_diff($previewUrls, $previewsToRemove);
            }

            // Add new previews
            if ($request->hasFile('previews')) {
                foreach ($request->file('previews') as $preview) {
                    $upload = Cloudinary::upload($preview->getRealPath(), [
                        'folder' => 'designs/previews'
                    ]);
                    $previewUrls[] = $upload->getSecurePath();
                }
            }

            $data['previews'] = !empty($previewUrls) ? array_values($previewUrls) : null;

            $design->update($data);

            return redirect()->route('partner.designs.index')
                ->with('success', 'Design updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update design: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Design $design)
    {
        // Check if the design belongs to the authenticated partner
        if ($design->partner_id !== Auth::id()) {
            abort(403);
        }

        try {
            // Note: In a real application, you might want to delete the images from Cloudinary first
            // But Cloudinary has automatic asset management, so it's optional
            
            $design->delete();
            
            return redirect()->route('partner.designs.index')
                ->with('success', 'Design deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete design: ' . $e->getMessage());
        }
    }
}