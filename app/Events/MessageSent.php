<?php

namespace App\Events;

use App\Models\Message;
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

    public $message;

    public function __construct(Message $message)
    {
        // Pastikan relasi user sudah dimuat sebelum dikirim
        $this->message = $message->load('user');
    }

    /**
     * Mendefinisikan data yang akan di-broadcast.
     * Ini memberi kita kontrol penuh atas data yang dikirim.
     */
    public function broadcastWith(): array
    {
        return [
            // Kita bungkus data pesan di dalam key 'message'
            'message' => [
                'id' => $this->message->id,
                'body' => $this->message->body,
                'conversation_id' => $this->message->conversation_id,
                'created_at' => $this->message->created_at->toIso8601String(),
                'user_id' => $this->message->user_id,
                'user' => [ // <-- Bagian ini memastikan data user selalu ada
                    'id' => $this->message->user->id,
                    'name' => $this->message->user->name,
                    'profile_photo_url' => $this->message->user->profile_photo_url
                ]
            ]
        ];
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }
}