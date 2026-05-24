<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'shop_name',
        'shop_description',
        'google_id',
        'profile_photo_url',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // A seller has many products
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // A user has many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Check if user is admin/seller
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
