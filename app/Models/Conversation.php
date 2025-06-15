<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * Mendefinisikan bahwa sebuah Conversation memiliki banyak User.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Mendefinisikan bahwa sebuah Conversation memiliki banyak Message.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function latestMessage()
    {
        // latestOfMany() adalah fungsi Eloquent yang sangat efisien 
        // untuk kasus seperti ini.
        return $this->hasOne(Message::class)->latestOfMany();
    }
}