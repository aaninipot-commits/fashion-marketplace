<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
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
            $file      = $request->file('image');
            $filename  = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('products'), $filename);
            $imagePath = 'products/' . $filename;
        }

        Product::create([
            'seller_id'   => Auth::id(),
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
        if ($product->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }
        $product->load('category');
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
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
            // Delete old image
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $file      = $request->file('image');
            $filename  = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('products'), $filename);
            $imagePath = 'products/' . $filename;
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
        if ($product->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}