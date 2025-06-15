<?php

namespace App\Events;

use App\Models\Message; // 1. Import model Message Anda
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Properti publik ini akan otomatis dikirim sebagai data event.
     * @var \App\Models\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Message $message
     * @return void
     */
    public function __construct(Message $message) // 2. Kita menerima objek Message, bukan hanya string
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // 3. (PALING PENTING) Menggunakan PrivateChannel untuk keamanan.
        // Ini memastikan hanya user dalam percakapan yang bisa "mendengar" pesannya.
        // Channel akan menjadi unik untuk setiap percakapan, misal: 'conversation.123'
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    /**
     * Nama event yang akan didengar oleh frontend (JavaScript).
     *
     * Jika fungsi ini tidak ada, Laravel akan menggunakan nama class secara default
     * (yaitu: 'App\Events\MessageSent'), yang mana itu sudah cukup bagus.
     * Jadi, fungsi broadcastAs() ini bersifat opsional.
     */
    // public function broadcastAs()
    // {
    //     return 'new-message'; // Contoh jika ingin nama custom
    // }
}