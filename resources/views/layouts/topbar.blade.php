<header class="bg-white shadow-sm border-b border-gray-200 h-20 flex items-center justify-between px-8 z-10 shrink-0">
    <form action="" method="GET" class="flex items-center bg-gray-100 rounded-full px-4 py-2 w-96">
        @if(request('tab'))
            <input type="hidden" name="tab" value="{{ request('tab') }}">
        @endif
        <button type="submit" class="focus:outline-none">
            <svg class="w-5 h-5 text-gray-400 hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Szukaj..." class="bg-transparent border-none focus:ring-0 text-sm ml-2 w-full text-gray-600 placeholder-gray-400">
    </form>

    <div class="flex items-center gap-6">
        <div class="text-sm font-medium text-orange-500">
            {{ Auth::user()->role->name ?? 'Pracownik' }}
        </div>
                <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold cursor-pointer">
            {{ substr(Auth::user()->name, 0, 2) }}
        </div>
    </div>
</header>
