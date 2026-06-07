<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <!-- Warm Orange/Gold abstract blobs -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-yellow-300/30 to-orange-500/20 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-orange-400/20 to-red-500/10 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold mb-4 border border-orange-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Serce Schroniska
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Witaj, {{ $user->name }}! 👋</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Dziękujemy, że jesteś z nami. Poniżej znajdziesz statusy swoich wniosków adopcyjnych oraz historię wsparcia naszych podopiecznych.</p>
                </div>
                
                <!-- Szybkie podsumowanie wpłat -->
                <div class="relative group bg-gradient-to-br from-[#FF6B35] to-orange-500 rounded-3xl p-6 shadow-lg overflow-hidden shrink-0 min-w-[280px] transform hover:scale-105 transition-transform duration-300 border border-white/20">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-orange-100 font-medium text-sm mb-1 uppercase tracking-wider">Twoje wsparcie łącznie</p>
                            <p class="text-3xl font-black text-white font-mono">{{ number_format($donations->sum('amount'), 2, ',', ' ') }} zł</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- SEKCJA 1: Moje Wnioski Adopcyjne -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Moje wnioski adopcyjne</h3>
                        <p class="text-sm text-gray-500 mt-1">Statusy Twoich zgłoszeń</p>
                    </div>
                    <div class="bg-[#FF6B35]/10 text-[#FF6B35] w-12 h-12 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>

                @if($applications->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-orange-100 text-orange-400 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-gray-900 font-bold mb-2">Brak wniosków</h4>
                        <p class="text-sm text-gray-500 mb-4 max-w-sm">Nie złożyłeś jeszcze żadnego wniosku o adopcję.</p>
                        <a href="{{ url('/') }}" class="text-sm font-bold text-[#FF6B35] hover:text-orange-600 bg-orange-50 px-4 py-2 rounded-full transition-colors">Przeglądaj zwierzęta &rarr;</a>
                    </div>
                @else
                    <div class="flex-1 space-y-4 overflow-y-auto max-h-[400px] custom-scrollbar pr-2">
                        @foreach($applications as $app)
                            <a href="{{ route('user.adoption-applications.show', $app) }}" class="block bg-gray-50 hover:bg-white rounded-2xl p-4 border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-300 group">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-xl overflow-hidden shrink-0 shadow-inner">
                                        @if($app->animal->images && $app->animal->images->count() > 0)
                                            <img src="{{ Storage::url($app->animal->images->first()->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-xl">{{ substr($app->animal->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors">{{ $app->animal->name }}</h4>
                                        <p class="text-xs text-gray-500 mb-2">Wysłano: {{ $app->created_at->format('d.m.Y H:i') }}</p>
                                        
                                        @if($app->status->name === 'PENDING')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-md bg-orange-100 text-orange-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Oczekujący
                                            </span>
                                        @elseif($app->status->name === 'APPROVED')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-md bg-green-100 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Zaakceptowany
                                            </span>
                                        @elseif($app->status->name === 'REJECTED')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-md bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Odrzucony
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-md bg-gray-100 text-gray-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Anulowany
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-gray-300 group-hover:text-orange-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- SEKCJA 2: Historia Moich Wpłat -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Historia wpłat</h3>
                        <p class="text-sm text-gray-500 mt-1">Dziękujemy za wsparcie zbiórek</p>
                    </div>
                    <div class="bg-emerald-50 text-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                @if($donations->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-400 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </div>
                        <h4 class="text-gray-900 font-bold mb-2">Brak wpłat</h4>
                        <p class="text-sm text-gray-500 mb-4 max-w-sm">Nie dokonałeś jeszcze żadnych wpłat wspierających nasze zbiórki.</p>
                        <a href="{{ route('fundraisers.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-2 rounded-full transition-colors">Wesprzyj zbiórki &rarr;</a>
                    </div>
                @else
                    <div class="flex-1 space-y-3 overflow-y-auto max-h-[400px] custom-scrollbar pr-2">
                        @foreach($donations as $donation)
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-300">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm truncate">{{ $donation->fundraiser->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $donation->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="pl-4 text-right">
                                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold font-mono text-sm rounded-lg border border-emerald-100 shadow-sm">
                                        +{{ number_format($donation->amount, 2, ',', ' ') }} zł
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
    </style>
</x-app-layout>
