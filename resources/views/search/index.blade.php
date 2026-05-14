@extends('layouts.app')

@section('title', 'Tìm kiếm tài liệu' . ($q ? " — {$q}" : '') . ' - HocLieuTieuHoc')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Search Bar --}}
    <div class="mb-6">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="{{ $q }}"
                       placeholder="Tìm tài liệu, đề thi, bài giảng..."
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white text-gray-800">
                <input type="hidden" name="sort" value="{{ $sort }}">
            </div>
            <button type="submit"
                    class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="hidden sm:inline ml-1">Tìm kiếm</span>
            </button>
        </form>
    </div>

    <div class="flex flex-col md:flex-row gap-6">

        {{-- LEFT SIDEBAR: Filters --}}
        <aside class="w-full md:w-64 flex-shrink-0">
            <form action="{{ route('search') }}" method="GET" id="filter-form">
                <input type="hidden" name="q" value="{{ $q }}">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-6">

                    {{-- Sort --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Sắp xếp theo</h3>
                        <div class="space-y-2">
                            @foreach(['newest' => 'Mới nhất', 'popular' => 'Xem nhiều nhất', 'downloads' => 'Tải nhiều nhất'] as $sortVal => $sortLabel)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="sort" value="{{ $sortVal }}"
                                       {{ $sort === $sortVal ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $sortLabel }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- TIER 1: Khối lớp --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-layer-group text-primary-400 mr-1"></i>Khối lớp
                        </h3>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="grade_cat" value=""
                                       {{ $gradeCatSlug === '' ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            @foreach($topCategories as $topCat)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="grade_cat" value="{{ $topCat->slug }}"
                                       {{ $gradeCatSlug === $topCat->slug ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700 flex-1">{{ $topCat->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- TIER 2A: Môn học (Lớp 1-5) --}}
                    @if($gradeCatSlug !== '' && $availableSubjects->isNotEmpty())
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-book text-primary-400 mr-1"></i>Môn học
                        </h3>
                        <input type="hidden" name="grade_cat" value="{{ $gradeCatSlug }}">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value=""
                                       {{ $mon === '' ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả môn</span>
                            </label>
                            @foreach($availableSubjects as $subj)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value="{{ $subj }}"
                                       {{ $mon === $subj ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $subj }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- TIER 2B: Loại hoạt động (Tiền Tiểu Học) --}}
                    @if($gradeCatSlug !== '' && $availableDocTypes->isNotEmpty())
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-palette text-primary-400 mr-1"></i>Hoạt động
                        </h3>
                        <input type="hidden" name="grade_cat" value="{{ $gradeCatSlug }}">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value=""
                                       {{ $mon === '' ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            @foreach($availableDocTypes as $dt)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value="{{ $dt }}"
                                       {{ $mon === $dt ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $dt }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- TIER 3: Dạng bài (only when subject selected for Lớp 1-5) --}}
                    @if($mon !== '' && $availableDangBai->isNotEmpty())
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-pen-to-square text-primary-400 mr-1"></i>Dạng bài
                        </h3>
                        @if($gradeCatSlug !== '')<input type="hidden" name="grade_cat" value="{{ $gradeCatSlug }}">@endif
                        <input type="hidden" name="mon" value="{{ $mon }}">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="dang" value=""
                                       {{ $dang === '' ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả dạng</span>
                            </label>
                            @foreach($availableDangBai as $dangVal)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="dang" value="{{ $dangVal }}"
                                       {{ $dang === $dangVal ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $dangVal }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- TIER 4: Loại tệp --}}
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-file text-primary-400 mr-1"></i>Loại tệp
                        </h3>
                        @if($gradeCatSlug !== '' && $availableSubjects->isEmpty() && $availableDocTypes->isEmpty())
                            <input type="hidden" name="grade_cat" value="{{ $gradeCatSlug }}">
                        @endif
                        @if($mon !== '' && $availableDangBai->isEmpty())<input type="hidden" name="mon" value="{{ $mon }}">@endif
                        @if($dang !== '')<input type="hidden" name="dang" value="{{ $dang }}">@endif
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value=""
                                       {{ $type === '' ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            @foreach(['pdf' => 'PDF', 'docx' => 'Word', 'pptx' => 'PowerPoint', 'xlsx' => 'Excel', 'zip' => 'ZIP'] as $typeVal => $typeLabel)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="{{ $typeVal }}"
                                       {{ $type === $typeVal ? 'checked' : '' }}
                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">{{ $typeLabel }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reset filters --}}
                    @if($q || $gradeCatSlug || $mon || $dang || $type)
                    <a href="{{ route('search') }}"
                       class="block text-center text-sm text-accent-500 hover:text-accent-600 font-medium">
                        <i class="fa-solid fa-xmark mr-1"></i>Xoá bộ lọc
                    </a>
                    @endif
                </div>
            </form>

            {{-- AD: Sidebar --}}
            @include('components.ad-slot', ['key' => 'ad_slot_sidebar'])
        </aside>

        {{-- MAIN: Results --}}
        <div class="flex-1 min-w-0">

            {{-- AD: above results --}}
            @include('components.ad-slot', ['key' => 'ad_slot_in_content'])

            {{-- Results count --}}
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">
                    @if($q)
                    Kết quả cho <strong class="text-gray-800">"{{ $q }}"</strong> —
                    @endif
                    <strong class="text-gray-800">{{ number_format($results->total()) }}</strong> tài liệu
                </p>
                <span class="text-sm text-gray-400">
                    Trang {{ $results->currentPage() }} / {{ $results->lastPage() }}
                </span>
            </div>

            @if($results->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                <i class="fa-solid fa-face-frown text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Không tìm thấy tài liệu</h3>
                <p class="text-sm text-gray-400 mb-6">Thử từ khoá khác hoặc xoá bộ lọc</p>
                <a href="{{ route('search') }}"
                   class="inline-flex items-center gap-2 bg-primary-500 text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-primary-600 transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>Xem tất cả tài liệu
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($results as $doc)
                <x-document-card :document="$doc" />
                @endforeach
            </div>

            {{-- Pagination --}}
            {{ $results->links('components.pagination') }}
            @endif
        </div>
    </div>
</div>
@endsection
