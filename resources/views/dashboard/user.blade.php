<x-app-layout>
    @php
        $activeTab = request('tab', 'dashboard');
    @endphp

    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- HEADER GLASSMORPHISM -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-yellow-300/30 to-orange-500/20 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-orange-400/20 to-red-500/10 rounded-full blur-3xl opacity-60"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold mb-4 border border-orange-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Witaj w Azylu
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Cześć, {{ $user->name }}! 👋</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zarządzaj swoimi adopcjami, polubionymi zwierzakami i wspieraj zbiórki finansowe.</p>
                </div>
                
                <div class="relative group bg-gradient-to-br from-[#FF6B35] to-orange-500 rounded-3xl p-6 shadow-lg overflow-hidden shrink-0 min-w-[280px] border border-white/20">
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

        <!-- TABS NAVIGATION -->
        <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-px">
            <a href="{{ route('dashboard', ['tab' => 'dashboard']) }}" class="px-5 py-3 rounded-t-2xl font-bold text-sm transition-all {{ $activeTab === 'dashboard' ? 'bg-white text-orange-600 border-t border-x border-gray-200 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                🎛️ Pulpit
            </a>
            <a href="{{ route('dashboard', ['tab' => 'applications']) }}" class="px-5 py-3 rounded-t-2xl font-bold text-sm transition-all {{ $activeTab === 'applications' ? 'bg-white text-orange-600 border-t border-x border-gray-200 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                📄 Wnioski Adopcyjne ({{ $applications->count() }})
            </a>
            <a href="{{ route('dashboard', ['tab' => 'likes']) }}" class="px-5 py-3 rounded-t-2xl font-bold text-sm transition-all {{ $activeTab === 'likes' ? 'bg-white text-orange-600 border-t border-x border-gray-200 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                ❤️ Polubione ({{ $likedAnimals->count() }})
            </a>
            <a href="{{ route('dashboard', ['tab' => 'donations']) }}" class="px-5 py-3 rounded-t-2xl font-bold text-sm transition-all {{ $activeTab === 'donations' ? 'bg-white text-orange-600 border-t border-x border-gray-200 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                💰 Wspierane zbiórki
            </a>
            <a href="{{ route('dashboard', ['tab' => 'settings']) }}" class="px-5 py-3 rounded-t-2xl font-bold text-sm transition-all {{ $activeTab === 'settings' ? 'bg-white text-orange-600 border-t border-x border-gray-200 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                ⚙️ Ustawienia profilu
            </a>
        </div>

        <!-- TAB CONTENT: DASHBOARD -->
        @if($activeTab === 'dashboard')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Quick stats -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Polubione zwierzęta</p>
                            <p class="text-3xl font-extrabold text-orange-500">{{ $likedAnimals->count() }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Złożone wnioski</p>
                            <p class="text-3xl font-extrabold text-blue-500">{{ $applications->count() }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Wsparte zbiórki</p>
                            <p class="text-3xl font-extrabold text-emerald-500">{{ $donations->unique('fundraiser_id')->count() }}</p>
                        </div>
                    </div>

                    <!-- Recommended Animals -->
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Może Cię zainteresować</h3>
                                <p class="text-xs text-gray-500">Zwierzaki dopasowane na podstawie Twoich polubień</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @forelse($suggestions as $animal)
                                @php
                                    $hasImage = $animal->images && $animal->images->count() > 0;
                                    $imagePath = $hasImage ? $animal->images->first()->file_name : null;
                                @endphp
                                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all flex flex-col justify-between">
                                    <div class="h-32 bg-gray-200 relative">
                                        @if($imagePath)
                                            <img src="{{ asset('storage/'.$imagePath) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-lg bg-orange-100">
                                                {{ substr($animal->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $animal->name }}</h4>
                                            <p class="text-xs text-gray-500 mb-3">{{ $animal->breed->species->name ?? 'Zwierzak' }} / {{ $animal->breed->name ?? 'Mieszaniec' }}</p>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <a href="{{ route('animals.show', $animal) }}" class="text-xs font-bold text-center bg-orange-500 text-white px-3 py-1.5 rounded-full hover:bg-orange-600 transition-colors w-full">Profil</a>
                                            
                                            <form action="{{ route('animals.like', $animal) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1.5 rounded-full bg-white hover:bg-red-50 border border-gray-100 text-gray-400 hover:text-red-500 transition-all">
                                                    ❤️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 text-center py-6 text-xs text-gray-400">
                                    Brak nowych propozycji na ten moment.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right column: recent donations sum or activity -->
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-3">Szybki kontakt</h3>
                    <div class="space-y-4 text-sm text-gray-600">
                        <div class="p-4 bg-orange-50 rounded-2xl border border-orange-100">
                            <p class="font-bold text-orange-700">Masz pytania co do wniosków?</p>
                            <p class="text-xs text-orange-600 mt-1">Napisz do nas na adres: <span class="font-semibold">adopcje@azyl.pl</span> lub zadzwoń: <span class="font-semibold">+48 123 456 789</span></p>
                        </div>
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                            <p class="font-bold text-emerald-700">Wsparcie finansowe</p>
                            <p class="text-xs text-emerald-600 mt-1">Wszystkie Twoje darowizny trafiają bezpośrednio na zakup karmy oraz leczenie chorych zwierząt. Dziękujemy!</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB CONTENT: APPLICATIONS -->
        @if($activeTab === 'applications')
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col min-h-[400px]">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Złożone Wnioski Adopcyjne</h3>
                        <p class="text-sm text-gray-500 mt-1">Statusy Twoich zgłoszeń adopcyjnych</p>
                    </div>
                </div>

                @if($applications->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-orange-100 text-orange-400 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-gray-900 font-bold mb-2">Brak wyników wyszukiwania</h4>
                        <p class="text-sm text-gray-500 mb-4 max-w-sm">Spróbuj wpisać inne słowa kluczowe w wyszukiwarce.</p>
                        <a href="{{ route('dashboard', ['tab' => 'applications']) }}" class="text-sm font-bold text-[#FF6B35] hover:text-orange-600 bg-orange-50 px-4 py-2 rounded-full transition-colors">Wyczyść wyszukiwanie</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($applications as $app)
                            <a href="{{ route('user.adoption-applications.show', $app) }}" class="group relative bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                                <div class="h-32 bg-gradient-to-br from-gray-200 to-gray-300 relative">
                                    @php
                                        $hasImg = $app->animal->images && $app->animal->images->count() > 0;
                                        $imgPath = $hasImg ? $app->animal->images->first()->file_name : null;
                                    @endphp
                                    @if($imgPath)
                                        <img src="{{ asset('storage/'.$imgPath) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-4xl text-white font-bold opacity-50 bg-gray-400">{{ substr($app->animal->name, 0, 1) }}</div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                                    <div class="absolute bottom-3 left-4 text-white">
                                        <h3 class="font-bold text-xl">{{ $app->animal->name }}</h3>
                                        <p class="text-xs text-gray-300">{{ $app->animal->breed->species->name ?? 'Zwierzę' }}</p>
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between bg-white">
                                    <div>
                                        <p class="text-xs text-gray-400 mb-3 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Wysłano: {{ $app->created_at->format('d.m.Y H:i') }}
                                        </p>
                                        <p class="text-sm text-gray-600 line-clamp-2 italic">"{{ $app->message ?? 'Brak wiadomości' }}"</p>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                        @if($app->status->name === 'PENDING')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Oczekujący
                                            </span>
                                        @elseif($app->status->name === 'APPROVED')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Zaakceptowany
                                            </span>
                                        @elseif($app->status->name === 'REJECTED')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Odrzucony
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Anulowany
                                            </span>
                                        @endif
                                        
                                        <span class="text-gray-400 group-hover:text-[#FF6B35] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- TAB CONTENT: LIKES -->
        @if($activeTab === 'likes')
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col min-h-[400px]">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Polubione Zwierzaki</h3>
                        <p class="text-sm text-gray-500 mt-1">Twoje ulubione zwierzaki gotowe do adopcji</p>
                    </div>
                </div>

                @if($likedAnimals->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-red-50 text-red-400 rounded-full flex items-center justify-center mb-4">
                            ❤️
                        </div>
                        <h4 class="text-gray-900 font-bold mb-2">Brak polubionych</h4>
                        <p class="text-sm text-gray-500 mb-4 max-w-sm">Gdy zobaczysz zwierzaka, którego chciałbyś wesprzeć lub adoptować, kliknij serduszko na jego profilu.</p>
                        <a href="{{ route('animals.index') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 bg-orange-50 px-4 py-2 rounded-full transition-colors">Przeglądaj zwierzaki</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($likedAnimals as $animal)
                            @php
                                $hasImg = $animal->images && $animal->images->count() > 0;
                                $imgPath = $hasImg ? $animal->images->first()->file_name : null;
                            @endphp
                            <div class="group relative bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                                <div class="h-40 bg-gradient-to-br from-gray-200 to-gray-300 relative">
                                    @if($imgPath)
                                        <img src="{{ asset('storage/'.$imgPath) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-4xl text-white font-bold opacity-50 bg-gray-400">{{ substr($animal->name, 0, 1) }}</div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                                    
                                    <!-- Unlike form -->
                                    <form action="{{ route('animals.like', $animal) }}" method="POST" class="absolute top-3 right-3">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-full bg-white/90 backdrop-blur-sm shadow-md hover:bg-red-50 text-red-500 hover:scale-110 transition-all font-bold">
                                            ❤️
                                        </button>
                                    </form>

                                    <div class="absolute bottom-3 left-4 text-white">
                                        <h3 class="font-bold text-xl">{{ $animal->name }}</h3>
                                        <p class="text-xs text-gray-300">{{ $animal->breed->species->name ?? 'Zwierzę' }}</p>
                                    </div>
                                </div>
                                <div class="p-5 flex-grow flex flex-col justify-between bg-white">
                                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $animal->description }}</p>
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-2">
                                        <span class="text-xs text-gray-500">Status: <strong class="text-orange-500">Do adopcji</strong></span>
                                        <a href="{{ route('animals.show', $animal) }}" class="text-xs font-bold bg-orange-500 text-white px-4 py-2 rounded-full hover:bg-orange-600 transition-colors">
                                            Zobacz profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- TAB CONTENT: DONATIONS -->
        @if($activeTab === 'donations')
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col min-h-[400px]">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Historia Wspieranych Zbiórek</h3>
                        <p class="text-sm text-gray-500 mt-1">Lista zbiórek finansowych, które zasilasz swoimi wpłatami</p>
                    </div>
                </div>

                @if($donations->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-400 rounded-full flex items-center justify-center mb-4">
                            💸
                        </div>
                        <h4 class="text-gray-900 font-bold mb-2">Brak wpłat</h4>
                        <p class="text-sm text-gray-500 mb-4 max-w-sm">Nie zasiliłeś jeszcze żadnej zbiórki. Możesz wesprzeć leczenie lub utrzymanie wybranego zwierzaka.</p>
                        <a href="{{ route('fundraisers.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-2 rounded-full transition-colors">Wesprzyj zbiórki</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($donations as $donation)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-300 gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-2xl flex items-center justify-center shrink-0">
                                        💰
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 text-base truncate">{{ $donation->fundraiser->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                            <span>Wpłacono: {{ $donation->created_at->format('d.m.Y H:i') }}</span>
                                            @if($donation->fundraiser->animal)
                                                <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded text-[10px] font-bold">Dla: {{ $donation->fundraiser->animal->name }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-4 border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                    <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-700 font-black font-mono text-base rounded-xl border border-emerald-100 shadow-sm">
                                        +{{ number_format($donation->amount, 2, ',', ' ') }} zł
                                    </span>
                                    <a href="{{ route('fundraisers.show', $donation->fundraiser) }}" class="text-xs font-bold text-orange-500 hover:underline">
                                        Zbiórka &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- TAB CONTENT: SETTINGS (PROFILE EDIT) -->
        @if($activeTab === 'settings')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Profile Information -->
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-3">Dane profilowe</h3>
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-1">Nazwa Użytkownika</label>
                            <input id="name" name="name" type="text" class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Adres Email</label>
                            <input id="email" name="email" type="email" class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow transition-colors">
                            Zapisz dane
                        </button>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-3">Zmień hasło</h3>
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="update_password_current_password" class="block text-xs font-bold text-gray-700 uppercase mb-1">Obecne hasło</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-xs font-bold text-gray-700 uppercase mb-1">Nowe hasło</label>
                            <input id="update_password_password" name="password" type="password" class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm" autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-1">Potwierdź nowe hasło</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 text-sm" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow transition-colors">
                            Zaktualizuj hasło
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
    </style>
</x-app-layout>
