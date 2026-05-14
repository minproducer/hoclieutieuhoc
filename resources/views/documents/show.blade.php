@extends('layouts.app')

@section('title', ($document->meta_title ?: $document->title) . ' - ' . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc'))
@section('description', $document->meta_description ?: Str::limit($document->description ?? '', 160))

@section('meta')
@if($document->thumbnail_display_url)
{{-- Page-specific image overrides the site default --}}
<meta property="og:image" content="{{ $document->thumbnail_display_url }}">
<meta name="twitter:image" content="{{ $document->thumbnail_display_url }}">
@endif
<meta property="og:type" content="article">
@endsection

@section('content')
@php
    use Illuminate\Support\Str;
    $fileTypeColors = [
        'pdf'   => 'badge-pdf',
        'docx'  => 'badge-docx',
        'pptx'  => 'badge-pptx',
        'xlsx'  => 'badge-xlsx',
        'zip'   => 'badge-zip',
        'image' => 'badge-image',
    ];
    $fileTypeIcons = [
        'pdf'   => 'fa-file-pdf',
        'docx'  => 'fa-file-word',
        'pptx'  => 'fa-file-powerpoint',
        'xlsx'  => 'fa-file-excel',
        'zip'   => 'fa-file-zipper',
        'image' => 'fa-file-image',
    ];
    $gradeGroup = null;
    if ($document->grade_level) {
        if ($document->grade_level <= 5) $gradeGroup = 'Tiểu học';
        elseif ($document->grade_level <= 9) $gradeGroup = 'THCS';
        else $gradeGroup = 'THPT';
    }
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-600">Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        @if($document->category)
        <a href="{{ route('category.show', $document->category->slug) }}" class="hover:text-primary-600">
            {{ $document->category->name }}
        </a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        @endif
        <span class="text-gray-700 font-medium truncate max-w-xs">{{ $document->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT: Document Info --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Doc Info Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                {{-- File type icon --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center">
                        <i class="fa-solid {{ $fileTypeIcons[$document->file_type] ?? 'fa-file' }} text-3xl text-primary-400"></i>
                    </div>
                    <div>
                        <span class="inline-block {{ $fileTypeColors[$document->file_type] ?? '' }} text-xs font-bold px-2.5 py-1 rounded-full uppercase mb-1">
                            {{ strtoupper($document->file_type) }}
                        </span>
                        @if($document->file_size_kb)
                        <div class="text-xs text-gray-500">{{ $document->file_size_formatted }}</div>
                        @endif
                    </div>
                </div>

                <h1 class="text-lg font-bold text-gray-900 mb-3 leading-snug">{{ $document->title }}</h1>

                @if($document->description)
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ $document->description }}</p>
                @endif

                {{-- Metadata --}}
                <dl class="space-y-2 text-sm">
                    @if($document->category)
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-folder text-gray-400 w-4"></i>Môn học
                        </dt>
                        <dd>
                            <a href="{{ route('category.show', $document->category->slug) }}"
                               class="text-primary-600 hover:underline font-medium">
                                {{ $document->category->name }}
                            </a>
                        </dd>
                    </div>
                    @endif

                    @if($document->grade_level)
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-gray-400 w-4"></i>Khối lớp
                        </dt>
                        <dd class="text-gray-700 font-medium">Lớp {{ $document->grade_level }} · {{ $gradeGroup }}</dd>
                    </div>
                    @endif

                    @if($document->page_count)
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-file-lines text-gray-400 w-4"></i>Số trang
                        </dt>
                        <dd class="text-gray-700">{{ number_format($document->page_count) }} trang</dd>
                    </div>
                    @endif

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-gray-400 w-4"></i>Lượt xem
                        </dt>
                        <dd class="text-gray-700">{{ number_format($document->view_count) }}</dd>
                    </div>

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-download text-gray-400 w-4"></i>Lượt tải
                        </dt>
                        <dd class="text-gray-700">{{ number_format($document->download_count) }}</dd>
                    </div>

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar text-gray-400 w-4"></i>Đăng lúc
                        </dt>
                        <dd class="text-gray-700">{{ $document->created_at->format('d/m/Y') }}</dd>
                    </div>
                </dl>

                {{-- AD: In-content below metadata --}}
                @include('components.ad-slot', ['key' => 'ad_slot_in_content'])

                {{-- Download CTA --}}
                @if($document->drive_file_id)
                <a href="{{ route('document.download.page', $document->slug) }}"
                   class="mt-6 w-full flex items-center justify-center gap-2 bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-download"></i>
                    Tải xuống miễn phí
                </a>
                @endif

                {{-- Back link --}}
                <a href="{{ url()->previous() }}"
                   class="mt-3 w-full flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-gray-700 py-2 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>

        {{-- RIGHT: Preview --}}
        <div class="lg:col-span-2 space-y-6">
            @if($document->drive_file_id)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <span class="text-sm font-medium text-gray-700">Xem trước tài liệu</span>
                </div>
                <iframe
                    src="https://drive.google.com/file/d/{{ $document->drive_file_id }}/preview"
                    class="w-full"
                    style="height:clamp(320px, 60vh, 700px);"
                    allow="autoplay"
                    loading="lazy"
                    title="Preview: {{ $document->title }}">
                </iframe>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-file-circle-question text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-500">Chưa có file xem trước cho tài liệu này.</p>
            </div>
            @endif

            {{-- Content --}}
            @if($document->content)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-circle-info text-primary-400 mr-2"></i>Thông tin chi tiết
                </h2>
                <div class="prose prose-sm max-w-none text-gray-700">
                    {!! $document->content !!}
                </div>
            </div>
            @endif

            {{-- AD: Sidebar --}}
            @include('components.ad-slot', ['key' => 'ad_slot_sidebar'])

            {{-- Related documents (tabbed) --}}
            @if($relatedByCategory->isNotEmpty() || $relatedByGrade->isNotEmpty())
            <div id="related-section">
                {{-- Tab header --}}
                <div class="flex items-center gap-1 mb-5">
                    <h2 class="font-bold text-gray-800 mr-3">
                        <i class="fa-solid fa-layer-group text-primary-400 mr-2"></i>Tài liệu liên quan
                    </h2>
                    @if($relatedByCategory->isNotEmpty())
                    <button onclick="switchRelatedTab('category')" id="tab-btn-category"
                            class="related-tab-btn active flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-primary-600 text-white shadow-sm">
                        <i class="fa-solid fa-folder"></i>
                        {{ $relatedLabel }}
                        <span class="opacity-70">({{ $relatedByCategory->count() }})</span>
                    </button>
                    @endif
                    @if($relatedByGrade->isNotEmpty())
                    <button onclick="switchRelatedTab('grade')" id="tab-btn-grade"
                            class="related-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Lớp {{ $document->grade_level }}
                        <span class="opacity-70">({{ $relatedByGrade->count() }})</span>
                    </button>
                    @endif
                </div>

                {{-- Same category --}}
                @if($relatedByCategory->isNotEmpty())
                <div id="tab-panel-category" class="related-tab-panel">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($relatedByCategory as $related)
                        <x-document-card :document="$related" />
                        @endforeach
                    </div>
                    @if($document->category)
                    <div class="mt-4 text-center">
                        <a href="{{ route('category.show', $document->category->slug) }}"
                           class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700 font-semibold hover:underline">
                            Xem tất cả trong {{ $document->category->name }}
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Same grade --}}
                @if($relatedByGrade->isNotEmpty())
                <div id="tab-panel-grade" class="related-tab-panel" style="display:none">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($relatedByGrade as $related)
                        <x-document-card :document="$related" />
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('search', ['grade' => $document->grade_level]) }}"
                           class="inline-flex items-center gap-2 text-sm text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                            Xem thêm tài liệu Lớp {{ $document->grade_level }}
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchRelatedTab(name) {
    // Update panels
    document.querySelectorAll('.related-tab-panel').forEach(function(el) {
        el.style.display = 'none';
        el.style.opacity = '0';
    });
    var panel = document.getElementById('tab-panel-' + name);
    if (panel) {
        panel.style.display = 'block';
        requestAnimationFrame(function() { panel.style.transition = 'opacity .2s'; panel.style.opacity = '1'; });
    }
    // Update buttons
    document.querySelectorAll('.related-tab-btn').forEach(function(btn) {
        btn.classList.remove('bg-primary-600','bg-emerald-600','text-white','shadow-sm');
        btn.classList.add('bg-gray-100','text-gray-600');
    });
    var activeBtn = document.getElementById('tab-btn-' + name);
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-100','text-gray-600');
        activeBtn.classList.add(name === 'grade' ? 'bg-emerald-600' : 'bg-primary-600', 'text-white', 'shadow-sm');
    }
}

// Lazy load document card images with IntersectionObserver
if ('IntersectionObserver' in window) {
    var imgObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imgObserver.unobserve(img);
            }
        });
    }, { rootMargin: '200px' });
    document.querySelectorAll('img[data-src]').forEach(function(img) { imgObserver.observe(img); });
}
</script>
@endsection
