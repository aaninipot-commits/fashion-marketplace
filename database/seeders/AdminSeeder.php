<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Seller 1
        User::create([
            'name'             => 'Seller One',
            'email'            => 'seller1@fashion.com',
            'password'         => Hash::make('seller123'),
            'role'             => 'admin',
            'shop_name'        => 'Fashion Hub',
            'shop_description' => 'Your go-to shop for trendy clothes!',
        ]);

        // Create Seller 2
        User::create([
            'name'             => 'Seller Two',
            'email'            => 'seller2@fashion.com',
            'password'         => Hash::make('seller123'),
            'role'             => 'admin',
            'shop_name'        => 'Style Central',
            'shop_description' => 'Premium clothing for everyone!',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Tops',    'gender' => 'mens',   'slug' => 'mens-tops'],
            ['name' => 'Bottoms', 'gender' => 'mens',   'slug' => 'mens-bottoms'],
            ['name' => 'Tops',    'gender' => 'womens', 'slug' => 'womens-tops'],
            ['name' => 'Bottoms', 'gender' => 'womens', 'slug' => 'womens-bottoms'],
            ['name' => 'Dresses', 'gender' => 'womens', 'slug' => 'womens-dresses'],
            ['name' => 'Tops',    'gender' => 'kids',   'slug' => 'kids-tops'],
            ['name' => 'Bottoms', 'gender' => 'kids',   'slug' => 'kids-bottoms'],
            ['name' => 'Dresses', 'gender' => 'kids',   'slug' => 'kids-dresses'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}