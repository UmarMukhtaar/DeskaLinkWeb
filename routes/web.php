<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\DesignController as DesignControllerManage;
use App\Http\Controllers\ServiceController as ServiceControllerManage;
use App\Http\Controllers\DesignControllerMarket;
use App\Http\Controllers\ServiceControllerMarket;
use App\Http\Controllers\PartnerControllerMarket;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Home route - accessible to all
Route::get('/', function () {
    if (auth()->check()) {
        // Jika user belum memilih role
        // if (empty(auth()->user()->role)) {
        //     return redirect()->route('role.selection');
        // }

        return match(auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'partner' => redirect()->route('partner.dashboard'),
            default => redirect()->route('client.market'),
        };
    }
    return view('welcome');
})->name('home');

// Authentication Routes
Auth::routes();

// // Google Login Routes
// Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
// Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);
// Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
// Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
// // Role Selection Route
// Route::get('/select-role', [LoginController::class, 'showRoleSelection'])->name('role.selection');
// Route::post('/select-role', [LoginController::class, 'processRoleSelection'])->name('role.process');

// GUEST ACCESSIBLE ROUTES (Marketplace)
Route::prefix('client')->group(function () {
    // Market & Public Detail - accessible to all
    Route::get('/market', [MarketController::class, 'index'])->name('client.market');
    Route::get('/design/{design}', [DesignControllerMarket::class, 'show'])->name('client.design.detail');
    Route::get('/service/{service}', [ServiceControllerMarket::class, 'show'])->name('client.service.detail');
    Route::get('/partner/{partner}', [PartnerControllerMarket::class, 'show'])->name('client.partner.profile');
});

// PROTECTED ROUTES (Require authentication)
Route::middleware('auth')->group(function () {
    // Route::get('/select-role', [LoginController::class, 'showRoleSelection'])->name('role.selection');
    // Route::post('/select-role', [LoginController::class, 'processRoleSelection'])->name('role.process');
    // Admin Routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User Management
        Route::get('/user-management', [AdminController::class, 'userManagement'])
            ->name('admin.user_management');
        
        Route::patch('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])
            ->name('admin.users.toggle-ban');
        
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('admin.users.destroy');
        
        // Content Management
        Route::get('/content-management', [AdminController::class, 'contentManagement'])
            ->name('admin.content_management');
        
        Route::post('/{type}s/{id}/approve', [AdminController::class, 'approveContent'])
            ->name('admin.content.approve');
        
        Route::post('/{type}s/{id}/reject', [AdminController::class, 'rejectContent'])
            ->name('admin.content.reject');
        
        Route::delete('/{type}s/{id}', [AdminController::class, 'deleteContent'])
            ->name('admin.content.destroy');
    });

    // Partner Routes
    Route::prefix('partner')->middleware('role:partner')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [PartnerController::class, 'dashboard'])->name('partner.dashboard');

        // Manage Services
        Route::resource('services', ServiceControllerManage::class)->names([
            'index'   => 'partner.services.index',
            'create'  => 'partner.services.create',
            'store'   => 'partner.services.store',
            'show'    => 'partner.services.show',
            'edit'    => 'partner.services.edit',
            'update'  => 'partner.services.update',
            'destroy' => 'partner.services.destroy',
        ]);

        // Manage Designs
        Route::resource('designs', DesignControllerManage::class)->names([
            'index'   => 'partner.designs.index',
            'create'  => 'partner.designs.create',
            'store'   => 'partner.designs.store',
            'show'    => 'partner.designs.show',
            'edit'    => 'partner.designs.edit',
            'update'  => 'partner.designs.update',
            'destroy' => 'partner.designs.destroy',
        ]);

        // Orders (Partner)
        Route::prefix('orders')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('partner.orders.index');
            
            // Item actions
            Route::post('/item/{orderItem}/accept', [OrderController::class, 'acceptItem'])->name('orders.accept.item');
            Route::post('/item/{orderItem}/reject', [OrderController::class, 'rejectItem'])->name('orders.reject.item');
            
            // Submit result
            Route::get('/{orderItem}/submit', [OrderController::class, 'showSubmitForm'])->name('orders.submit.show');
            Route::post('/{orderItem}/submit', [OrderController::class, 'submitResult'])->name('orders.submit');
        });
    });

    // Client Routes (authenticated users with client role)
    Route::prefix('client')->middleware('role:client')->group(function () {
        // Cart Routes
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('client.cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
        Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('client.cart.remove');

        // Checkout Routes
        Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('client.checkout.direct');
        Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('client.checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('client.checkout.process');
        Route::get('/checkout/notes', [CheckoutController::class, 'showNotes'])->name('client.checkout.notes');
        Route::get('/checkout/notes/direct', [CheckoutController::class, 'showDirectNotes'])->name('client.checkout.direct_notes');
        Route::post('/checkout/notes', [CheckoutController::class, 'saveNotes'])->name('client.checkout.save-notes');
        Route::post('/checkout/notes/direct', [CheckoutController::class, 'saveDirectNotes'])->name('client.checkout.save-direct-notes');
        Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('client.checkout.success');

        // Order Routes
        Route::prefix('orders')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::post('/item/{orderItem}/cancel', [OrderController::class, 'cancelItem'])->name('orders.cancel.item');
        });
    });

    // Profile Routes (for all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Registration Routes (accessible to guests)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);