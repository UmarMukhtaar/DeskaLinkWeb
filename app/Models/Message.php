<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'body',
        'read_at',
    ];

    /**
     * Properti yang harus di-cast ke tipe data tertentu.
     * Ini akan memperbaiki masalah 'Invalid Date' Anda.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Relasi ke model User (mendapatkan data pengirim).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Conversation.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}