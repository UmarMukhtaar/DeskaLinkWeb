<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'item_type',
        'title',
        'price',
        'thumbnail',
        'partner_id',
    ];

    // protected $casts = [
    //     'price' => 'decimal:2',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];

    // // Relasi polymorphic ke item (design atau service)
    // public function item()
    // {
    //     return $this->morphTo();
    // }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan partner
    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
}