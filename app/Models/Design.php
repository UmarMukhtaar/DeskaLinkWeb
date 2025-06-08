<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Design extends Model
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
        'previews',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'previews' => 'array',
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
        return $this->hasMany(CartItem::class, 'item_id')->where('item_type', 'design');
        // return $this->morphMany(CartItem::class, 'item');
    }

    // Relasi dengan order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'item_id')->where('item_type', 'design');
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
        return $query->where('title', 'LIKE', "%{$term}%");
    }

    // Accessor untuk mendapatkan jumlah total gambar (thumbnail + previews)
    public function getTotalImagesAttribute()
    {
        $previewCount = $this->previews ? count($this->previews) : 0;
        return $previewCount + 1; // +1 untuk thumbnail
    }
}