<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'seller'])
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts'));
    }
}