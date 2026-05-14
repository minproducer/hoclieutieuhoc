@extends('layouts.app')

@section('title', $category->name . ' - ' . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc'))
@section('description', $category->description ?: "Tài liệu môn {$category->name} — PDF, DOCX, PPTX cho tất cả khối lớp. Tải miễn phí tại " . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc') . ".")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-600">Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <span class="text-gray-700 font-medium">{{ $category->name }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-2xl p-8 mb-8 flex items-center gap-6">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $category->icon ?? 'fa-folder' }} text-3xl text-white"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold mb-1">{{ $category->name }}</h1>
            @if($category->description)
            <p class="text-primary-100 text-sm">{{ $category->description }}</p>
            @endif
            <div class="flex items-center gap-4 mt-3 text-sm text-primary-200">
                <span><i class="fa-solid fa-file-lines mr-1"></i>{{ number_format($documents->total()) }} tài liệu</span>
            </div>
        </div>
    </div>

    {{-- Child Category Tabs (e.g. sub-subjects within a grade) --}}
    @if($category->children->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Chọn môn / dạng đề</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($category->children->sortBy('sort_order') as $child)
            <a href="{{ route('category.show', $child->slug) }}"
               class="flex items-center gap-2 bg-white border border-gray-200 hover:border-primary-400 hover:bg-primary-50 hover:text-primary-700 text-gray-700 rounded-xl px-4 py-2 text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid {{ $child->icon ?? 'fa-folder' }} text-primary-400 text-xs"></i>
                {{ $child->name }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Documents Grid --}}
    @if($documents->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
        <i class="fa-solid fa-folder-open text-6xl text-gray-200 mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-600 mb-2">Chưa có tài liệu nào</h3>
        <p class="text-sm text-gray-400">Danh mục này chưa có tài liệu. Quay lại sau nhé!</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($documents as $doc)
        <x-document-card :document="$doc" />
        @endforeach
    </div>

    {{-- Pagination --}}
    {{ $documents->links('components.pagination') }}
    @endif
</div>
@endsection
