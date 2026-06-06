<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Schronisko Azyl')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .text-azyl-orange { color: #FF6B35; }
        .bg-azyl-orange { background-color: #FF6B35; }
        .hover-bg-azyl-orange:hover { background-color: #E55A2B; }
        .border-azyl-orange { border-color: #FF6B35; }
    </style>
</head>
<body class="antialiased text-gray-800 flex flex-col min-h-screen">
    <nav class="bg-white border-b border-gray-100 w-full relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Azyl Logo" class="h-10 w-auto">
                    <span class="text-2xl font-bold text-gray-900 tracking-tight">Azyl</span>
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-gray-900 font-semibold border-b-2 border-azyl-orange pb-1' : 'text-gray-500 font-medium hover:text-gray-900 transition' }}">Strona główna</a>
                    <a href="#" class="text-gray-500 font-medium hover:text-gray-900 transition">Zwierzęta</a>
                    <a href="{{ url('/o-nas') }}" class="{{ request()->is('o-nas') ? 'text-gray-900 font-semibold border-b-2 border-azyl-orange pb-1' : 'text-gray-500 font-medium hover:text-gray-900 transition' }}">O nas</a>
                    <a href="#" class="text-gray-500 font-medium hover:text-gray-900 transition">Jak pomóc</a>
                    <a href="#" class="text-gray-500 font-medium hover:text-gray-900 transition">Kontakt</a>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 font-medium hover:text-gray-900 transition">Pulpit</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-gray-900 px-5 py-2 border border-gray-200 hover:border-gray-300 rounded-full transition">Zaloguj się</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-azyl-orange text-white px-6 py-2 rounded-full font-medium hover-bg-azyl-orange transition shadow-sm">Zarejestruj się</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow">
        @yield('content')
    </main>
    <footer class="bg-[#1a202c] text-gray-400 py-12 text-sm mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Azyl Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-white tracking-tight">Azyl</span>
                    </div>
                    <p class="mb-6 leading-relaxed">
                        Schronisko „Azyl” od 20 lat daje drugie życie zwierzętom potrzebującym domu, miłości i opieki.
                    </p>
                    <div class="flex space-x-4">
                        <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 cursor-pointer transition text-white">f</div>
                        <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 cursor-pointer transition text-white">ig</div>
                        <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 cursor-pointer transition text-white">yt</div>
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4 text-base">Szybkie linki</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/o-nas') }}" class="hover:text-white transition">O nas</a></li>
                        <li><a href="#" class="hover:text-white transition">Zwierzęta</a></li>
                        <li><a href="#" class="hover:text-white transition">Jak pomóc</a></li>
                        <li><a href="#" class="hover:text-white transition">Regulamin</a></li>
                        <li><a href="#" class="hover:text-white transition">Polityka prywatności</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4 text-base">Kontakt</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-azyl-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>ul. Schroniskowa 12<br/>00-001 Warszawa</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-azyl-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+48 22 123 45 67</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-azyl-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>kontakt@azyl.pl</span>
                        </li>
                        <li class="flex items-start gap-3 mt-2 text-xs">
                            <svg class="w-5 h-5 text-azyl-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Pon–Pt: 9:00–18:00<br/>Sob–Nd: 10:00–16:00</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4 text-base">Wesprzyj nas</h3>
                    <p class="mb-4">Każda złotówka trafia bezpośrednio do zwierząt potrzebujących pomocy.</p>
                    <a href="#" class="bg-azyl-orange text-white px-6 py-2.5 rounded-lg font-medium hover-bg-azyl-orange transition inline-block mb-4 shadow-sm">Adoptuj wirtualnie</a>
                    <p class="text-xs text-gray-500">
                        Nr konta: 12 1234 5678 9012 3456 7890 1234<br/>
                        Tytułem: „Darowizna dla Azylu”
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-xs">
                <p>&copy; {{ date('Y') }} Azyl – Schronisko dla Zwierząt. Wszelkie prawa zastrzeżone.</p>
                <p class="mt-2 md:mt-0">Zarejestrowany podmiot: Fundacja Azyl, KRS: 0000123456</p>
            </div>
        </div>
    </footer>
</body>
</html>
