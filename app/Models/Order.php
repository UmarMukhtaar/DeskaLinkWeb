<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total_amount',
        'status',
    ];

    // protected $casts = [
    //     'total_amount' => 'decimal:2',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];

    // Relasi dengan client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relasi dengan order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}