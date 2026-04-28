<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $sellerId = Auth::id();

        // Only show seller's own stats
        $totalProducts  = Product::where('seller_id', $sellerId)->count();
        $totalMessages  = Message::whereIn('product_id',
                            Product::where('seller_id', $sellerId)->pluck('id')
                          )->count();
        $unreadMessages = Message::whereIn('product_id',
                            Product::where('seller_id', $sellerId)->pluck('id')
                          )->where('is_read', false)->where('sender', 'user')->count();
        $totalCategories = Category::count();
        $totalUsers      = User::where('role', 'user')->count();

        $recentMessages = Message::with(['user', 'product'])
            ->whereIn('product_id',
                Product::where('seller_id', $sellerId)->pluck('id')
            )
            ->where('sender', 'user')
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::with('category')
            ->where('seller_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalMessages',
            'unreadMessages',
            'totalCategories',
            'totalUsers',
            'recentMessages',
            'recentProducts'
        ));
    }
}