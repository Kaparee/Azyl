<header class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200 h-16 lg:h-20 flex items-center justify-between gap-3 px-4 sm:px-6 lg:px-8 shrink-0 min-w-0">
    <div class="flex items-center gap-3 flex-1 min-w-0">
        <button
            type="button"
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden p-2 -ml-1 rounded-lg text-gray-500 hover:text-orange-500 hover:bg-gray-100 transition-colors shrink-0"
            aria-label="Otwórz menu"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        @if($searchConfig)
            <form method="GET" action="{{ route($searchConfig['route']) }}" class="flex items-center bg-gray-100 rounded-full px-3 sm:px-4 py-2 flex-1 min-w-0 max-w-md lg:max-w-none lg:w-96 lg:flex-none">
                @foreach(request()->except(['search', 'page']) as $key => $value)
                    @if(is_string($value) || is_numeric($value))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="focus:outline-none shrink-0">
                    <svg class="w-5 h-5 text-gray-400 hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchConfig['placeholder'] }}" class="bg-transparent border-none focus:ring-0 text-sm ml-2 w-full min-w-0 text-gray-600 placeholder-gray-400">
            </form>
        @endif
    </div>

    <div class="flex items-center gap-3 sm:gap-6 shrink-0">
        <div class="hidden sm:block text-sm font-medium text-orange-500">
            {{ $userRole ?? 'Pracownik' }}
        </div>
        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold cursor-pointer text-sm sm:text-base">
            {{ substr(Auth::user()->name, 0, 2) }}
        </div>
    </div>
</header>
