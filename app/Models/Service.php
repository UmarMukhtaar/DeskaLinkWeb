<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id',
        'title',
        'description',
        'price',
        'original_price',
        'status',
        'thumbnail',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relasi dengan partner
    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    // Relasi dengan cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'item_id')->where('item_type', 'service');
        // return $this->morphMany(CartItem::class, 'item');
    }

    // Relasi dengan order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'item_id')->where('item_type', 'service');
        // return $this->morphMany(OrderItem::class, 'item');
    }

    // Scope untuk status approved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }
}