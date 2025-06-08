<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'google_id',
        'username',
        'full_name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'profile_photo_url',
        'description',
        'is_profile_completed',
        'balance',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relasi dengan orders sebagai client
    // public function clientOrders()
    // {
    //     return $this->hasMany(Order::class, 'client_id');
    // }
    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'partner_id');
    }

    // Relasi dengan designs/services sebagai partner
    public function designs()
    {
        return $this->hasMany(Design::class, 'partner_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'partner_id');
    }
}
// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

//     protected $primaryKey = 'user_id';
//     public $incrementing = false;
//     protected $keyType = 'string';

//     protected $fillable = [
//         'user_id',
//         /'google_id',
//         'username',
//         'password',
//         'full_name',
//         'email',
//         /'phone',
//         'role',
//         'status',
//         /'profile_photo_url',
//         'description',
//         /'is_profile_completed',
//         'balance',
//     ];

//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'is_profile_completed' => 'boolean',
//     ];
// }