<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = Cache::remember('home_stats', 300, function () {
            return [
                'total_documents'  => Document::where('status', 'published')->count(),
                'total_views'      => Document::where('status', 'published')->sum('view_count'),
                'total_downloads'  => Document::where('status', 'published')->sum('download_count'),
                'total_categories' => Category::count(),
            ];
        });

        $featuredDocs = Cache::remember('home_featured', 300, function () {
            return Document::with('category')
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest()
                ->limit(8)
                ->get();
        });

        $recentDocs = Cache::remember('home_recent', 120, function () {
            return Document::with('category')
                ->where('status', 'published')
                ->latest()
                ->limit(8)
                ->get();
        });

        $categories = Cache::remember('home_categories', 3600, function () {
            return Category::whereNull('parent_id')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        });

        return view('home', compact('stats', 'featuredDocs', 'recentDocs', 'categories'));
    }
}
