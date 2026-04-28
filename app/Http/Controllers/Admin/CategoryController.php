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

        Category::create([
            'name'   => $request->name,
            'gender' => $request->gender,
            'slug'   => Str::slug($request->gender . '-' . $request->name),
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

        $category->update([
            'name'   => $request->name,
            'gender' => $request->gender,
            'slug'   => Str::slug($request->gender . '-' . $request->name),
        ]);

        return response()->json(['success' => 'Category updated successfully.']);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}