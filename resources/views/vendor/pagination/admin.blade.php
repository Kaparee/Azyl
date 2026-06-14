@if ($paginator->hasPages())
    <nav class="flex justify-center mt-4">
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 rounded-full border border-slate-200 text-slate-300 flex items-center justify-center">
                    ‹
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 rounded-full border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-100">
                    ‹
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 rounded-full border border-slate-200 text-slate-400 flex items-center justify-center">
                        ...
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 rounded-full bg-[#FF6B35] text-white flex items-center justify-center font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-full border border-slate-200 text-slate-700 flex items-center justify-center hover:bg-slate-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 rounded-full border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-100">
                    ›
                </a>
            @else
                <span class="w-9 h-9 rounded-full border border-slate-200 text-slate-300 flex items-center justify-center">
                    ›
                </span>
            @endif
        </div>
    </nav>
@endif
