@if ($paginator->hasPages())
    {{-- Mały paginator do panelu admina, bez domyślnych dużych ikon SVG. --}}
    <nav class="flex justify-center mt-4">
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 rounded-xl border border-slate-200 text-slate-300 flex items-center justify-center">
                    ‹
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 rounded-xl border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-100">
                    ‹
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 rounded-xl border border-slate-200 text-slate-400 flex items-center justify-center">
                        ...
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-xl border border-slate-200 text-slate-700 flex items-center justify-center hover:bg-slate-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 rounded-xl border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-100">
                    ›
                </a>
            @else
                <span class="w-9 h-9 rounded-xl border border-slate-200 text-slate-300 flex items-center justify-center">
                    ›
                </span>
            @endif
        </div>
    </nav>
@endif
