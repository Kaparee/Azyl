<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up pb-12">
        
        <!-- HEADER -->
        <div class="relative overflow-hidden rounded-3xl bg-white border border-gray-100 shadow-sm p-8 sm:p-10">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-yellow-300/20 to-orange-500/10 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-orange-400/10 to-red-500/5 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-sm font-semibold mb-4 border border-orange-100 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Witaj w Azylu
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Cześć, {{ $user->name }}! 👋</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zarządzaj swoimi adopcjami, polubionymi zwierzakami i wspieraj zbiórki finansowe.</p>
                </div>
                
                <div class="relative group bg-gradient-to-br from-[#FF6B35] to-orange-500 rounded-3xl p-6 shadow-lg overflow-hidden shrink-0 min-w-[280px] border border-white/20">
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

        @if (session('status'))
            <div class="rounded-2xl bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-8">

            <!-- Moje wnioski adopcyjne -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Moje wnioski adopcyjne</h3>
                    @if($applications->isNotEmpty())
                        <a href="{{ route('user.adoption-applications.index') }}" class="text-sm font-bold text-[#FF6B35] hover:text-orange-600">Zobacz wszystkie &rarr;</a>
                    @endif
                </div>
                
                @if($applications->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-500">Nie złożyłeś jeszcze żadnego wniosku adopcyjnego.</p>
                        <a href="{{ route('animals.index') }}" class="inline-block mt-4 text-xs font-bold text-orange-500 hover:underline">Przeglądaj zwierzęta do adopcji &rarr;</a>
                    </div>
                @else
                    <div class="space-y-4 max-h-[320px] overflow-y-auto custom-scrollbar pr-1">
                        @foreach($applications as $app)
                        <div class="border border-gray-100 rounded-2xl p-4 flex items-center justify-between hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                                    <x-animal-image :src="$app->animal->photo_url" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $app->animal->name }}</h4>
                                    <p class="text-xs text-gray-500">Złożono: {{ $app->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                @if($app->status->name === 'PENDING')
                                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-bold">Oczekujący</span>
                                @elseif($app->status->name === 'APPROVED')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Zaakceptowany</span>
                                @elseif($app->status->name === 'REJECTED')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Odrzucony</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-bold">Anulowany</span>
                                @endif
                                <a href="{{ route('user.adoption-applications.show', $app) }}" class="text-[#FF6B35] hover:text-orange-600 font-semibold text-sm">Szczegóły &rarr;</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Historia wpłat - pełna szerokość -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Historia wpłat</h3>
                        <p class="text-sm text-gray-500 mt-1">Wsparcie dla zbiórek</p>
                    </div>
                </div>

                @if($donations->isEmpty())
                    <div class="flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <h4 class="text-gray-900 font-bold mb-2">Brak wpłat</h4>
                        <p class="text-sm text-gray-500 mb-4">Nie dokonałeś jeszcze żadnych wpłat.</p>
                        <a href="{{ route('fundraisers.index') }}" class="text-sm font-bold text-[#FF6B35] hover:underline">Wesprzyj zbiórki &rarr;</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto custom-scrollbar pr-1">
                        @foreach($donations as $donation)
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-300">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-gray-900 text-sm truncate">{{ $donation->fundraiser->title }}</h4>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ $donation->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold font-mono text-sm rounded-lg border border-emerald-100 shadow-sm">
                                        +{{ number_format($donation->amount, 2, ',', ' ') }} zł
                                    </span>
                                    <a href="{{ route('fundraisers.show', $donation->fundraiser) }}" class="text-xs font-bold text-[#FF6B35] hover:underline">Zbiórka &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
    </style>
</x-app-layout>
