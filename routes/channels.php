<?php

use App\Models\Conversation; // <-- Import model Conversation
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// ======================================================================
// ---> BAGIAN PENTING: Tambahkan otorisasi untuk chat <---
Broadcast::channel('conversation.{conversation}', function ($user, Conversation $conversation) {
    // Izinkan user mendengarkan channel ini HANYA JIKA
    // user tersebut adalah anggota dari percakapan ini.
    return $conversation->users->contains($user);
});
// ======================================================================