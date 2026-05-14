<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q            = trim($request->input('q', ''));
        $gradeCatSlug = $request->input('grade_cat', '');   // top-level: tien-tieu-hoc / lop-1 / ...
        $mon          = $request->input('mon', '');         // subject: Toán / Tiếng Việt / Tô màu / ...
        $dang         = $request->input('dang', '');        // doc type: Đề kiểm tra / Đề ôn tập / ...
        $type         = $request->input('type', '');        // file extension: pdf / docx / ...
        $sort         = $request->input('sort', 'newest');

        // Remove legacy 'loai' and 'category' params — kept for BC redirect
        $loai    = $request->input('loai', '');
        $catSlug = $request->input('category', '');

        $query = Document::with('category')->where('status', 'published');

        // Full-text search or LIKE fallback
        if ($q !== '') {
            if (mb_strlen($q) >= 3) {
                $query->whereRaw(
                    'MATCH(title, description) AGAINST (? IN BOOLEAN MODE)',
                    ['+' . implode('* +', explode(' ', $q)) . '*']
                );
            } else {
                $query->where(function ($q2) use ($q) {
                    $q2->where('title', 'LIKE', "%{$q}%")
                       ->orWhere('description', 'LIKE', "%{$q}%");
                });
            }
        }

        // ── Category filtering (multi-dimensional) ──────────────────────
        // Find matching sub-categories based on grade + subject + doc_type
        $catQuery = Category::whereNotNull('parent_id'); // only sub-categories

        if ($gradeCatSlug !== '') {
            $parentCat = Category::where('slug', $gradeCatSlug)->whereNull('parent_id')->first();
            if ($parentCat) {
                $catQuery->where('parent_id', $parentCat->id);
            }
        }

        if ($mon !== '') {
            // $mon can be a subject (Toán, Tiếng Việt) OR a pre-K doc_type (Tô màu, Toán tư duy...)
            $catQuery->where(function ($q2) use ($mon) {
                $q2->where('subject', $mon)->orWhere('doc_type', $mon);
            });
        }

        if ($dang !== '') {
            $catQuery->where('doc_type', $dang);
        }

        // Legacy: direct category slug (BC)
        if ($catSlug !== '') {
            $subCat = Category::where('slug', $catSlug)->first();
            if ($subCat) {
                $query->where('category_id', $subCat->id);
                goto applyTypeAndSort;
            }
        }

        // Legacy: loai param (BC)
        if ($loai !== '') {
            $catQuery->where('name', 'LIKE', "%{$loai}%");
        }

        $matchedCatIds = $catQuery->pluck('id');

        if ($matchedCatIds->isNotEmpty()) {
            $query->whereIn('category_id', $matchedCatIds);
        } elseif ($gradeCatSlug !== '' && $mon === '' && $dang === '') {
            // grade only — include parent + children
            $parentCat = Category::with('children')->where('slug', $gradeCatSlug)->first();
            if ($parentCat) {
                $ids = $parentCat->children->pluck('id')->push($parentCat->id);
                $query->whereIn('category_id', $ids);
            }
        }

        applyTypeAndSort:

        if ($type !== '') {
            $query->where('file_type', $type);
        }

        switch ($sort) {
            case 'popular':   $query->orderByDesc('view_count');     break;
            case 'downloads': $query->orderByDesc('download_count'); break;
            default:          $query->latest();                      break;
        }

        $results       = $query->paginate(12)->withQueryString();
        $topCategories = Category::with('children')->whereNull('parent_id')->ordered()->get();

        // Available subjects for selected grade (for sidebar)
        $availableSubjects = collect();
        $availableDocTypes = collect();

        if ($gradeCatSlug !== '') {
            $parentCat = $topCategories->firstWhere('slug', $gradeCatSlug);
            if ($parentCat) {
                $children = $parentCat->children;
                // Subjects (Toán, Tiếng Việt) — only for Lớp 1-5
                $availableSubjects = $children->whereNotNull('subject')->pluck('subject')->unique()->values();
                // Pre-K doc_types (Tô màu, Toán tư duy...) — when no subjects
                if ($availableSubjects->isEmpty()) {
                    $availableDocTypes = $children->whereNotNull('doc_type')->pluck('doc_type')->unique()->values();
                }
            }
        }

        // Doc types for selected subject (Đề kiểm tra, Đề ôn tập, ...)
        $availableDangBai = collect();
        if ($mon !== '' && $gradeCatSlug !== '') {
            $parentCat = $topCategories->firstWhere('slug', $gradeCatSlug);
            if ($parentCat) {
                $availableDangBai = $parentCat->children
                    ->where('subject', $mon)
                    ->whereNotNull('doc_type')
                    ->pluck('doc_type')->unique()->values();
            }
        } elseif ($mon !== '' && $gradeCatSlug === '') {
            // All grades: get unique doc_types for this subject
            $availableDangBai = Category::whereNotNull('parent_id')
                ->where('subject', $mon)
                ->pluck('doc_type')->unique()->values();
        }

        return view('search.index', compact(
            'results', 'topCategories',
            'availableSubjects', 'availableDocTypes', 'availableDangBai',
            'q', 'gradeCatSlug', 'mon', 'dang', 'type', 'sort'
        ));
    }
}
