<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/70 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <!-- Medical Green/Teal abstract blobs -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-gradient-to-br from-teal-400/20 to-emerald-400/10 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-gradient-to-tl from-cyan-400/20 to-teal-200/10 rounded-full blur-3xl opacity-70"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-teal-600 text-sm font-semibold mb-4 border border-teal-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Centrum Medyczne Azylu
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Panel Weterynarza</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zarządzaj zdrowiem pacjentów, przeglądaj kartoteki medyczne i nadzoruj zlecenia dla wolontariuszy.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT COLUMN (Patients) -->
            <div class="lg:col-span-12 flex flex-col gap-8">
                <!-- PATIENTS CARD -->
                <div class="group relative bg-gradient-to-br from-teal-500 to-cyan-600 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/clean-medical.png')] opacity-10 mix-blend-overlay"></div>
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10 flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <h3 class="text-5xl font-black text-white mb-2">{{ $patientsCount }}</h3>
                        <p class="text-cyan-50 font-medium text-lg">Zwierząt gotowych na przegląd</p>
                    </div>
                    
                    <a href="{{ route('medical-records.index') }}" class="relative z-10 mt-8 flex items-center justify-center gap-2 w-full bg-white text-teal-600 hover:bg-teal-50 px-6 py-4 rounded-xl text-base font-bold transition-colors duration-300 shadow-md">
                        Otwórz Kartoteki Medyczne
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
    </style>
</x-app-layout>
