<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:191',
            'gender' => 'required|in:mens,womens,kids',
        ]);

        $slug = Str::slug($request->gender . '-' . $request->name);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        Category::create([
            'name'   => $request->name,
            'gender' => $request->gender,
            'slug'   => $slug,
        ]);

        return response()->json(['success' => 'Category created successfully.']);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'   => 'required|string|max:191',
            'gender' => 'required|in:mens,womens,kids',
        ]);

        $slug = Str::slug($request->gender . '-' . $request->name);
        $count = Category::where('slug', $slug)
                    ->where('id', '!=', $category->id)
                    ->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $category->update([
            'name'   => $request->name,
            'gender' => $request->gender,
            'slug'   => $slug,
        ]);

        return response()->json([
            'success' => 'Category updated successfully.',
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}