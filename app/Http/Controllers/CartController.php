<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Service;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with(['partner'])->get();
        $totalPrice = $cartItems->sum('price');
        
        return view('client.cart.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'item_type' => 'required|in:service,design',
        ]);
        
        $user = Auth::user();
        
        // Check if item already in cart
        $existingItem = $user->cartItems()
            ->where('item_id', $request->item_id)
            ->where('item_type', $request->item_type)
            ->first();
            
        if ($existingItem) {
            return back()->with('error', 'Item sudah ada di keranjang');
        }
        
        try {
            // Get item details
            if ($request->item_type === 'service') {
                $item = Service::findOrFail($request->item_id);
            } else {
                $item = Design::findOrFail($request->item_id);
            }
            
            // Add to cart
            $cartItem = new CartItem([
                'item_id' => $item->id,
                'item_type' => $request->item_type,
                'title' => $item->title,
                'price' => $item->price,
                'thumbnail' => $item->thumbnail,
                'partner_id' => $item->partner_id,
            ]);
            
            $user->cartItems()->save($cartItem);
            
            return back()->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan item ke keranjang');
        }
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
        
        try {
            $cartItem->delete();
            return back()->with('success', 'Item berhasil dihapus dari keranjang');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus item dari keranjang');
        }
    }
}