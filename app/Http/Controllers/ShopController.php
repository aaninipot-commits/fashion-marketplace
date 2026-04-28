<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with(['category', 'seller'])
            ->where('status', 'available')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            })
            ->latest()
            ->get();

        $categories = Category::withCount('products')->get();
        return view('shop.index', compact('products', 'categories', 'search'));
    }

    public function mens(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with(['category', 'seller'])
            ->where('status', 'available')
            ->whereHas('category', function ($q) {
                $q->where('gender', 'mens');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            })
            ->latest()
            ->get();

        $categories = Category::where('gender', 'mens')->get();
        return view('shop.mens', compact('products', 'categories', 'search'));
    }

    public function womens(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with(['category', 'seller'])
            ->where('status', 'available')
            ->whereHas('category', function ($q) {
                $q->where('gender', 'womens');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            })
            ->latest()
            ->get();

        $categories = Category::where('gender', 'womens')->get();
        return view('shop.womens', compact('products', 'categories', 'search'));
    }

    public function kids(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with(['category', 'seller'])
            ->where('status', 'available')
            ->whereHas('category', function ($q) {
                $q->where('gender', 'kids');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            })
            ->latest()
            ->get();

        $categories = Category::where('gender', 'kids')->get();
        return view('shop.kids', compact('products', 'categories', 'search'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'seller']);
        $relatedProducts = Product::with(['category', 'seller'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'available')
            ->take(4)
            ->get();
        return view('shop.product', compact('product', 'relatedProducts'));
    }
}