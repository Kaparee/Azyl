<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <!-- Warm Orange/Pink abstract blobs -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-orange-400/30 to-pink-500/10 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-yellow-400/20 to-orange-500/10 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold mb-4 border border-orange-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Strefa Wolontariusza
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Panel Wolontariusza</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Witaj ponownie! Sprawdź swoje postępy, odbierz nagrody i zobacz, co dzisiaj na Ciebie czeka.</p>
                </div>
            </div>
        </div>

        @php
            $totalToday = $completedToday + $pending;
            $progressPercent = $totalToday > 0 ? round(($completedToday / $totalToday) * 100) : 0;
        @endphp

        <!-- POSTĘP DNIA (PROGRESS BAR) -->
        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Twój dzisiejszy postęp</h3>
                    <p class="text-sm text-gray-500">Ukończono {{ $completedToday }} z {{ $totalToday }} zaplanowanych zadań</p>
                </div>
                <div class="text-3xl font-black text-orange-500">{{ $progressPercent }}%</div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-orange-400 to-[#FF6B35] h-4 rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $progressPercent }}%">
                    <!-- Animacja połysku na pasku -->
                    <div class="absolute top-0 left-0 bottom-0 right-0 overflow-hidden rounded-full">
                        <div class="w-full h-full bg-white/20 animate-shimmer absolute" style="width: 50%; transform: skewX(-20deg);"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- STAT 1 -->
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-gray-900 mb-1">{{ $completedToday }}</h3>
                <p class="text-gray-500 font-medium">Zrobione dziś</p>
            </div>
            
            <!-- STAT 2 -->
            <div class="group bg-gradient-to-br from-[#FF6B35] to-orange-500 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="relative z-10 text-4xl font-black text-white mb-1">{{ $pending }}</h3>
                <p class="relative z-10 text-orange-100 font-medium">Oczekujące dzisiaj</p>
            </div>

            <!-- STAT 3 -->
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-gray-900 mb-1">{{ $tasks->where('status', 3)->count() }}</h3>
                <p class="text-gray-500 font-medium">Wszystkie wykonane</p>
            </div>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('volunteer-tasks.index') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-gradient-to-r from-[#FF6B35] to-orange-500 rounded-full hover:shadow-[0_0_20px_rgba(255,107,53,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-600">
                Otwórz Mój Plan Dnia
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%) skewX(-20deg); }
            100% { transform: translateX(200%) skewX(-20deg); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite linear;
        }
    </style>
</x-app-layout>
