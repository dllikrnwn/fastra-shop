@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm font-bold" style="color: var(--text-secondary);">
            @if ($paginator->firstItem())
                <span style="color: var(--text-primary);">{{ $paginator->firstItem() }}</span> – <span style="color: var(--text-primary);">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            dari <span style="color: var(--text-primary);">{{ $paginator->total() }}</span>
        </div>

        <div class="flex gap-1">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-sm font-bold rounded-lg cursor-not-allowed opacity-50" style="border: 2px solid var(--border); color: var(--text-secondary);">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all hover:-translate-x-0.5" style="border: 2px solid var(--border); box-shadow: 2px 2px 0 var(--border); color: var(--text-primary);">←</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-sm font-bold rounded-lg" style="border: 2px solid var(--border); color: var(--text-secondary);">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 text-sm font-black rounded-lg" style="background: var(--accent); color: #000; border: 2px solid var(--border); box-shadow: 2px 2px 0 var(--border);">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all hover:-translate-y-0.5" style="border: 2px solid var(--border); box-shadow: 2px 2px 0 var(--border); color: var(--text-primary);">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all hover:-translate-x-0.5" style="border: 2px solid var(--border); box-shadow: 2px 2px 0 var(--border); color: var(--text-primary);">→</a>
            @else
                <span class="px-3 py-2 text-sm font-bold rounded-lg cursor-not-allowed opacity-50" style="border: 2px solid var(--border); color: var(--text-secondary);">→</span>
            @endif
        </div>
    </nav>
@endif
