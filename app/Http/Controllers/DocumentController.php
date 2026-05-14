<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DownloadLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function show(string $slug): View
    {
        $document = Document::with(['category', 'uploader'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $document->increment('view_count');

        // Related: same category (up to 6)
        $relatedByCategory = Document::with('category')
            ->where('status', 'published')
            ->where('category_id', $document->category_id)
            ->where('id', '!=', $document->id)
            ->orderByDesc('download_count')
            ->limit(6)
            ->get();

        // Fallback: same subject (parent category / sibling categories) if same category yields < 3
        if ($relatedByCategory->count() < 3 && $document->category) {
            $subjectSlug = $document->category->subject; // e.g. "toan", "tieng-viet"
            $excludeIds  = $relatedByCategory->pluck('id')->push($document->id);
            if ($subjectSlug) {
                $siblings = \App\Models\Category::where('subject', $subjectSlug)->pluck('id');
                $more = Document::with('category')
                    ->where('status', 'published')
                    ->whereIn('category_id', $siblings)
                    ->whereNotIn('id', $excludeIds)
                    ->orderByDesc('download_count')
                    ->limit(6 - $relatedByCategory->count())
                    ->get();
                $relatedByCategory = $relatedByCategory->merge($more);
            }
        }

        // Fallback: featured/popular docs when category still empty
        if ($relatedByCategory->isEmpty()) {
            $relatedByCategory = Document::with('category')
                ->where('status', 'published')
                ->where('id', '!=', $document->id)
                ->orderByDesc('view_count')
                ->limit(6)
                ->get();
        }

        // Related: same grade level, different category (up to 6)
        $relatedByGrade = collect();
        if ($document->grade_level) {
            $excludeIds = $relatedByCategory->pluck('id')->push($document->id);
            $relatedByGrade = Document::with('category')
                ->where('status', 'published')
                ->where('grade_level', $document->grade_level)
                ->whereNotIn('id', $excludeIds)
                ->orderByDesc('download_count')
                ->limit(6)
                ->get();
        }

        // Legacy: merged for backward compat (download-wait still uses $relatedDocs)
        $relatedDocs = $relatedByCategory->take(3);

        // Label for the first tab
        $relatedLabel = $document->category?->name ?? 'Cùng môn';
        if ($relatedByCategory->isNotEmpty() && $document->category) {
            $firstCatId = $relatedByCategory->first()->category_id ?? null;
            if ($firstCatId !== $document->category_id) {
                $relatedLabel = 'Tài liệu nổi bật';
            }
        }

        return view('documents.show', compact('document', 'relatedDocs', 'relatedByCategory', 'relatedByGrade', 'relatedLabel'));
    }

    public function downloadPage(string $slug): View
    {
        $document = Document::with(['category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedDocs = Document::with('category')
            ->where('status', 'published')
            ->where('category_id', $document->category_id)
            ->where('id', '!=', $document->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('documents.download-wait', compact('document', 'relatedDocs'));
    }

    public function download(string $slug): RedirectResponse
    {
        $document = Document::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment download count
        $document->increment('download_count');

        // Update category doc_count is handled by observer or manual update
        // Log the download
        DownloadLog::create([
            'document_id'   => $document->id,
            'ip_address'    => request()->ip(),
            'user_agent'    => substr(request()->userAgent() ?? '', 0, 500),
            'downloaded_at' => now(),
        ]);

        $downloadUrl = "https://drive.google.com/uc?export=download&id={$document->drive_file_id}";

        return redirect()->away($downloadUrl);
    }
}
