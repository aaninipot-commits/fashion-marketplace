<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'size',
        'color',
        'stock',
        'status',
    ];

    // A product belongs to a seller
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A product has many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}