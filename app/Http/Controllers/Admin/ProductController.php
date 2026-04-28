<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Only show seller's own products
        $products   = Product::with('category')
                        ->where('seller_id', Auth::id())
                        ->latest()
                        ->get();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:191',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'nullable|string|max:191',
            'color'       => 'nullable|string|max:191',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,unavailable',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'seller_id'   => Auth::id(), // ← Link to current seller
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'size'        => $request->size,
            'color'       => $request->color,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'image'       => $imagePath,
        ]);

        return response()->json(['success' => 'Product created successfully.']);
    }

    public function show(Product $product)
    {
        // Make sure seller can only view their own product
        if ($product->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }
        $product->load('category');
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        // Make sure seller can only update their own product
        if ($product->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:191',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size'        => 'nullable|string|max:191',
            'color'       => 'nullable|string|max:191',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,unavailable',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'size'        => $request->size,
            'color'       => $request->color,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'image'       => $imagePath,
        ]);

        return response()->json(['success' => 'Product updated successfully.']);
    }

    public function destroy(Product $product)
    {
        // Make sure seller can only delete their own product
        if ($product->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}