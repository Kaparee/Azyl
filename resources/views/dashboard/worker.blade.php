<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/70 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-[#FF6B35]/20 to-orange-400/5 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FF6B35]/10 text-[#FF6B35] text-sm font-semibold mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Centrum Operacyjne
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Panel Pracownika</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zarządzaj codziennymi obowiązkami schroniska, nadzoruj zwierzęta i weryfikuj najnowsze wnioski adopcyjne.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- KARTA ZWIERZĄT -->
            <div class="group relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-100 to-transparent rounded-bl-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                    </div>
                    <span class="flex items-center gap-1 text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        Aktualne
                    </span>
                </div>
                
                <div>
                    <h3 class="text-5xl font-black text-gray-900 mb-2">{{ $animalsCount }}</h3>
                    <p class="text-gray-500 font-medium text-lg">Zwierząt pod opieką w schronisku</p>
                </div>
                
                <a href="{{ url('/') }}" class="mt-8 flex items-center justify-center gap-2 w-full bg-gray-50 hover:bg-blue-600 text-gray-700 hover:text-white px-6 py-4 rounded-xl text-base font-bold transition-colors duration-300">
                    Otwórz katalog zwierząt
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <!-- KARTA WNIOSKÓW -->
            <div class="group relative bg-gradient-to-br from-[#FF6B35] to-orange-500 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="relative z-10 flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    @if($pendingApplicationsCount > 0)
                    <span class="flex items-center gap-1 text-sm font-bold text-[#FF6B35] bg-white px-3 py-1 rounded-full shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping absolute"></span>
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        Wymaga akcji
                    </span>
                    @endif
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-5xl font-black text-white mb-2">{{ $pendingApplicationsCount }}</h3>
                    <p class="text-orange-100 font-medium text-lg">Oczekujących wniosków adopcyjnych</p>
                </div>
                
                <a href="{{ route('adoption.index') }}" class="relative z-10 mt-8 flex items-center justify-center gap-2 w-full bg-white/10 hover:bg-white text-white hover:text-[#FF6B35] px-6 py-4 rounded-xl text-base font-bold transition-all duration-300 backdrop-blur-sm border border-white/20">
                    Przejdź do weryfikacji
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
