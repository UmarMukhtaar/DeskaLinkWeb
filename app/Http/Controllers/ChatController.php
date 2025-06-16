<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message; // <-- 1. Import model Message
use App\Events\MessageSent; // <-- 2. Import event MessageSent
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Menampilkan halaman utama chat.
     */
    public function index(Conversation $conversation = null)
    {
        // Ambil semua percakapan milik user yang login
        $conversations = Auth::user()->conversations()->latest('updated_at')->get();
        
        // Kirim data ke view
        return view('chat.index', [
            'conversations' => $conversations,
            'activeConversationId' => $conversation ? $conversation->id : null,
        ]);
    }

    public function startOrFindConversation(User $partner)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $partner->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa memulai percakapan dengan diri sendiri.');
        }

        // Query untuk mencari percakapan yang melibatkan HANYA dua user ini
        $conversation = $currentUser->conversations()
            ->whereHas('users', function ($query) use ($partner) {
                $query->where('user_id', $partner->id);
            }, '=', 1)
            ->whereHas('users', function ($query) {
                $query->whereIn('user_id', [Auth::id()]);
            })
            ->has('users', '=', 2) // Pastikan hanya ada 2 user
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$currentUser->id, $partner->id]);
        }
        
        // Arahkan ke halaman chat, dengan membawa ID percakapan yang aktif
        return redirect()->route('chat.index', ['conversation' => $conversation->id]);
    }

    /**
     * Mengambil semua pesan dari sebuah percakapan. (Untuk API)
     */
    public function getMessages(Conversation $conversation)
    {
        // Otorisasi: pastikan user yang request adalah anggota percakapan
        if (!$conversation->users->contains(Auth::user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($conversation->messages()->with('user')->get());
    }

    /**
     * Menyimpan pesan baru ke database dan mem-broadcast event. (Untuk API)
     */
    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Otorisasi
        if (!$conversation->users->contains(Auth::user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validasi
        $request->validate([
            'body' => 'required|string',
        ]);

        // 3. Simpan pesan baru ke database
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);
        
        // Memuat relasi user agar bisa langsung ditampilkan di frontend
        $message->load('user');

        // 4. Panggil event untuk di-broadcast ke Pusher
        broadcast(new MessageSent($message))->toOthers();

        // 5. Kembalikan pesan yang baru dibuat sebagai response
        return response()->json($message, 201);
    }
    public function getConversations()
    {
        // Ambil percakapan, dan muat juga relasi 'users' 
        // agar nama partner bisa ditampilkan di frontend.
        $conversations = Auth::user()->conversations()->with('users')->latest('updated_at')->get();
        
        return response()->json($conversations);
    }
    public function destroyConversation(Conversation $conversation)
    {
        // Otorisasi: Pastikan user yang menghapus adalah anggota percakapan
        if (!$conversation->users->contains(Auth::user())) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $conversation->delete();

        return redirect()->route('chat.index')->with('success', 'Percakapan berhasil dihapus.');
    }
    public function updateMessage(Request $request, Message $message)
    {
        // Otorisasi menggunakan MessagePolicy yang sudah dibuat
        $this->authorize('update', $message);

        $validated = $request->validate(['body' => 'required|string']);

        $message->update(['body' => $validated['body']]);
        
        $message->load('user'); // Muat kembali relasi user

        // Broadcast event baru agar semua tahu pesan ini diupdate
        // Anda perlu membuat event MessageUpdated, mirip seperti MessageSent
        // broadcast(new MessageUpdated($message))->toOthers();

        return response()->json($message);
    }
}