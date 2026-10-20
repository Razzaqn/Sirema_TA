@if ($paginator->hasPages())
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2 py-3">

    {{-- INFO --}}
    <p class="text-sm text-gray-500">
        Showing
        <span class="font-semibold text-gray-800">{{ $paginator->firstItem() }}</span>
        to
        <span class="font-semibold text-gray-800">{{ $paginator->lastItem() }}</span>
        of
        <span class="font-semibold text-gray-800">{{ $paginator->total() }}</span>
        results
    </p>

    {{-- PAGE LINKS --}}
    <div class="flex items-center gap-1.5">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <span
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/40 text-slate-500 cursor-not-allowed">
            <i class="ri-arrow-left-s-line"></i>
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 text-white hover:bg-slate-700 transition">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)

        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span class="w-9 h-9 flex items-center justify-center text-slate-400 text-sm">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-white text-slate-900 font-bold text-sm shadow-sm">
            {{ $page }}
        </span>
        @else
        <a href="{{ $url }}"
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 text-white text-sm font-medium hover:bg-slate-700 transition">
            {{ $page }}
        </a>
        @endif
        @endforeach
        @endif

        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800 text-white hover:bg-slate-700 transition">
            <i class="ri-arrow-right-s-line"></i>
        </a>
        @else
        <span
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/40 text-slate-500 cursor-not-allowed">
            <i class="ri-arrow-right-s-line"></i>
        </span>
        @endif

    </div>

</div>
@endif
