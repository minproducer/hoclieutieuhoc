<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\Setting;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $siteUrl = rtrim(Setting::get('site_url', config('app.url')), '/');

        $categories = Category::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $documents = Document::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->limit(5000)
            ->get();

        $content = view('sitemap', compact('siteUrl', 'categories', 'documents'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
