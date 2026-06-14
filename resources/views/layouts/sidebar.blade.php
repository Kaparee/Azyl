<aside class="w-64 bg-[#111827] text-gray-300 flex flex-col h-full min-h-0 shadow-lg z-20 shrink-0">
    <div class="h-20 flex items-center px-6 border-b border-gray-800 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            </div>
            <div>
                <h1 class="text-white font-bold text-xl leading-tight">Azyl</h1>
                <span class="text-xs text-orange-400 font-medium">{{ Auth::user()->role->name ?? 'Pracownik' }}</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto min-h-0 custom-scrollbar mt-6 px-4 space-y-1 pb-4">
        @php
            $role = Auth::user()->role?->name;
        @endphp

        <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="view-grid">
            Pulpit główny
        </x-sidebar-link>

        @if(in_array($role, ['Admin', 'Pracownik']))
        <x-sidebar-link href="{{ route('admin.animals.index') }}" :active="request()->routeIs('admin.animals.*') || request()->routeIs('admin.species.*') || request()->routeIs('admin.breeds.*')" icon="paw">
            Zwierzęta
        </x-sidebar-link>
        @elseif($role == 'Wolontariusz')
        <x-sidebar-link href="{{ route('panel.animals.index') }}" :active="request()->routeIs('panel.animals.*')" icon="paw">
            Zwierzęta
        </x-sidebar-link>
        @elseif($role == 'Adoptujący')
        <x-sidebar-link href="{{ route('user.liked-animals.index') }}" :active="request()->routeIs('user.liked-animals.*')" icon="heart">
            Polubione zwierzęta
        </x-sidebar-link>
        @endif

        @if(in_array($role, ['Admin', 'Pracownik']))
        <x-sidebar-link href="{{ route('admin.adoption-applications.index') }}" :active="request()->routeIs('admin.adoption-applications.*')" icon="document">
            Wnioski adopcyjne
        </x-sidebar-link>
        @endif

        @if($role == 'Adoptujący')
        <x-sidebar-link href="{{ route('user.adoption-applications.index') }}" :active="request()->routeIs('user.adoption-applications.*')" icon="document-text">
            Moje wnioski
        </x-sidebar-link>
        @endif

        @if(!in_array($role, ['Adoptujący', 'Weterynarz']))
        <x-sidebar-link href="{{ route('volunteer-tasks.index') }}" :active="request()->routeIs('volunteer-tasks.*')" icon="clipboard-list">
            Plan dnia
        </x-sidebar-link>
        @endif

        @if(in_array($role, ['Admin', 'Weterynarz']))
        <x-sidebar-link href="{{ route('medical-records.index') }}" :active="request()->routeIs('medical-records.*')" icon="stethoscope">
            Kartoteki medyczne
        </x-sidebar-link>
        @endif

        <x-sidebar-link href="{{ route('fundraisers.index') }}" :active="request()->routeIs('fundraisers.*')" icon="currency-dollar">
            Finanse / Zbiórki
        </x-sidebar-link>
        
        @if($role == 'Admin')
        <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="users">
            Użytkownicy
        </x-sidebar-link>
        @endif

        @if(in_array($role, ['Admin', 'Pracownik']))
        <x-sidebar-link href="{{ route('admin.news.index') }}" :active="request()->routeIs('admin.news.*')" icon="annotation">
            Aktualności
        </x-sidebar-link>
        @endif

        <div class="pt-6 mt-6 border-t border-gray-800 space-y-1">
            <x-sidebar-link href="{{ url('/') }}" :active="false" icon="external-link">
                Strona główna
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.edit')" icon="cog">
                Mój profil
            </x-sidebar-link>
        </div>
    </nav>

    <div class="p-6 border-t border-gray-800 shrink-0">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">{{ Auth::user()->role->name ?? 'User' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-sm text-red-400 hover:text-red-300 transition-colors w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Wyloguj się
            </button>
        </form>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #374151; border-radius: 20px; }
    </style>
</aside>
