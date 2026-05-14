@props(['document'])

@php
    $fileTypeLabels = [
        'pdf'   => 'PDF',
        'docx'  => 'DOCX',
        'pptx'  => 'PPTX',
        'xlsx'  => 'XLSX',
        'zip'   => 'ZIP',
        'image' => 'Ảnh',
    ];
    $fileTypeIcons = [
        'pdf'   => 'fa-file-pdf',
        'docx'  => 'fa-file-word',
        'pptx'  => 'fa-file-powerpoint',
        'xlsx'  => 'fa-file-excel',
        'zip'   => 'fa-file-zipper',
        'image' => 'fa-file-image',
    ];
    $gradeLevelGroup = null;
    if ($document->grade_level !== null && $document->grade_level !== '') {
        if ($document->grade_level == 0) $gradeLevelGroup = 'Tiền Tiểu học';
        elseif ($document->grade_level <= 5) $gradeLevelGroup = 'Lớp ' . $document->grade_level;
    }
@endphp

<a href="{{ route('document.show', $document->slug) }}"
   class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col overflow-hidden">

    {{-- Thumbnail / Type Icon --}}
    <div class="relative h-36 bg-gradient-to-br from-primary-50 to-blue-50 flex items-center justify-center">
        @if($document->thumbnail_display_url)
            <img src="{{ $document->thumbnail_display_url }}" alt="{{ $document->title }}"
                 loading="lazy" decoding="async"
                 class="w-full h-full object-cover">
        @else
            <i class="fa-solid {{ $fileTypeIcons[$document->file_type] ?? 'fa-file' }} text-5xl text-primary-200 group-hover:text-primary-300 transition-colors"></i>
        @endif

        {{-- File type badge --}}
        <span class="absolute top-2 right-2 badge-{{ $document->file_type }} text-xs font-bold px-2 py-0.5 rounded-full uppercase">
            {{ $fileTypeLabels[$document->file_type] ?? strtoupper($document->file_type) }}
        </span>
    </div>

    {{-- Content --}}
    <div class="flex flex-col flex-1 p-4">
        {{-- Title --}}
        <h3 class="font-semibold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-primary-600 transition-colors mb-2">
            {{ $document->title }}
        </h3>

        {{-- Category & Grade --}}
        <div class="flex flex-wrap gap-1 mb-3">
            @if($document->category)
            <span class="inline-flex items-center gap-1 text-xs bg-primary-50 text-primary-700 px-2 py-0.5 rounded-full">
                <i class="fa-solid fa-folder text-primary-400 text-[10px]"></i>
                {{ $document->category->name }}
            </span>
            @endif
            @if($gradeLevelGroup)
            <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                {{ $gradeLevelGroup }}
            </span>
            @endif
        </div>

        {{-- Stats --}}
        <div class="mt-auto flex items-center justify-between text-xs text-gray-400">
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-eye"></i>
                {{ number_format($document->view_count) }}
            </span>
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-download"></i>
                {{ number_format($document->download_count) }}
            </span>
            @if($document->file_size_kb)
            <span>{{ $document->file_size_formatted }}</span>
            @endif
        </div>
    </div>
</a>
