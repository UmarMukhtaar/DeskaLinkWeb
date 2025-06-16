<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Route untuk mengambil daftar percakapan
    Route::get('/conversations', [ChatController::class, 'getConversations'])
        ->name('api.conversations.index');

    // Route untuk mengambil pesan dari satu percakapan
    Route::get('/conversations/{conversation}/messages', [ChatController::class, 'getMessages'])
        ->name('api.messages.index');

    // Route untuk mengirim pesan baru
    Route::post('/conversations/{conversation}/messages', [ChatController::class, 'storeMessage'])
        ->name('api.messages.store');

    Route::patch('/messages/{message}', [ChatController::class, 'updateMessage'])
    ->name('api.messages.update');
});
