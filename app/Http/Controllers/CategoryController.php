<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return Inertia::render('categories/Index', compact('categories'));
    }

    public function create()
    {
        return Inertia::render('categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'color' => 'required|string|in:red,blue,green,yellow,purple,pink,orange,cyan,gray,indigo,teal,lime',
        ]);

        // Generate unique ID from name (lowercase, replace spaces with dashes)
        $uniqueId = strtolower(str_replace(' ', '-', trim($request->name)));
        
        // Ensure uniqueness by appending number if needed
        $originalId = $uniqueId;
        $counter = 1;
        while (Category::where('user_id', auth()->id())->where('unique_id', $uniqueId)->exists()) {
            $uniqueId = $originalId . '-' . $counter;
            $counter++;
        }

        Category::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'unique_id' => $uniqueId,
            'color' => $request->color,
            'icon' => 'tag',
        ]);

        return redirect()->route('categories.index')->with('message', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        return Inertia::render('categories/Edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'color' => 'required|string|in:red,blue,green,yellow,purple,pink,orange,cyan,gray,indigo,teal,lime',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('message', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Category deleted successfully!');
    }
}
