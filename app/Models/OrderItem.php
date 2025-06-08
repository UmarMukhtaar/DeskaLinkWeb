<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'item_type',
        'title',
        'price',
        'partner_id',
        'client_id',
        'status',
        'result_url',
        'note',
        'rejection_reason',
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

    // Relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi dengan partner
    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    // Relasi dengan client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}