<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'message',
        'sender',
        'is_read',
    ];

    // A message belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A message belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}