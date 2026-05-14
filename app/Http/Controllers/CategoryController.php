<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::with('children')->where('slug', $slug)->firstOrFail();

        $documents = $category->documents()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'documents'));
    }
}
