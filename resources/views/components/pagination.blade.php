@if ($paginator->hasPages())
<nav class="flex items-center justify-center gap-1 mt-8" aria-label="Phân trang">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 text-sm text-gray-300 cursor-not-allowed">
            <i class="fa-solid fa-chevron-left"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-2 text-sm text-gray-600 hover:bg-white hover:text-primary-600 rounded-lg transition-colors">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-3 py-2 text-sm text-gray-400">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-2 text-sm font-semibold bg-primary-500 text-white rounded-lg">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="px-3 py-2 text-sm text-gray-600 hover:bg-white hover:text-primary-600 rounded-lg transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-2 text-sm text-gray-600 hover:bg-white hover:text-primary-600 rounded-lg transition-colors">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    @else
        <span class="px-3 py-2 text-sm text-gray-300 cursor-not-allowed">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
    @endif
</nav>
@endif
