@extends('layouts.public')

@section('title', 'Schronisko Azyl - Strona Główna')

@section('content')
    @php
        $recentAnimals = \App\Models\Animal::with(['breed.species', 'animalImages.image'])
            ->where('status', 0) // AVAILABLE
            ->withCount('recentClicks')
            ->orderByDesc('recent_clicks_count')
            ->take(5)
            ->get();
        $recentFundraisers = \App\Models\Fundraiser::with('animal')->where('status', 1)->latest()->take(2)->get();
    @endphp
    <div class="relative bg-gray-900 min-h-[600px] flex flex-col justify-center items-center text-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero_shelter.png') }}" alt="Pies ze schroniska" class="w-full h-full object-cover opacity-60">
        </div>

        <div class="relative z-10 max-w-4xl px-4 mt-8 flex flex-col items-center">
            <div class="inline-block bg-white/20 backdrop-blur-md text-white text-xs px-3 py-1.5 rounded-full mb-6 font-medium border border-white/20">
                <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2"></span>Schronisko certyfikowane od 2004 roku
            </div>
            
            <h1 class="text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Znajdź swojego <br/>
                <span class="text-azyl-orange">nowego przyjaciela</span>
            </h1>
            
            <p class="mt-6 text-lg md:text-xl text-gray-200 max-w-2xl font-medium">
                W schronisku Azyl czekają na Ciebie zwierzęta pełne miłości. Daj im drugą szansę – razem tworzycie historię wartą opowiedzenia.
            </p>
            
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('animals.index') }}" class="bg-azyl-orange text-white px-8 py-3.5 rounded-full font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2 shadow-lg">
                    Zobacz zwierzęta
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('fundraisers.index') }}" class="bg-transparent text-white border border-white/40 px-8 py-3.5 rounded-full font-semibold hover:bg-white/10 transition flex items-center justify-center gap-2">
                    Wspieraj nas
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </a>
            </div>
            <div class="mt-12 flex flex-wrap justify-center gap-4">
                <div class="bg-black/30 backdrop-blur-sm text-gray-300 text-sm px-4 py-2 rounded-lg border border-white/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    150+ adoptowanych
                </div>
                <div class="bg-black/30 backdrop-blur-sm text-gray-300 text-sm px-4 py-2 rounded-lg border border-white/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    20 lat doświadczenia
                </div>
                <div class="bg-black/30 backdrop-blur-sm text-gray-300 text-sm px-4 py-2 rounded-lg border border-white/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    Certyfikowane schronisko
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div>
                    <p class="text-3xl font-extrabold text-azyl-orange">150+</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Adoptowanych zwierząt</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-azyl-orange">80+</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Zwierząt pod opieką</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-azyl-orange">45</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Aktywnych wolontariuszy</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-azyl-orange">20 lat</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Doświadczenia</p>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-1">Czekają na Ciebie</p>
                <h2 class="text-3xl font-bold text-gray-900">Zwierzęta czekające na dom</h2>
            </div>
            <a href="{{ route('animals.index') }}" class="hidden sm:flex text-azyl-orange font-medium hover:underline items-center text-sm">
                Zobacz wszystkie <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($recentAnimals as $index => $animal)
            @php
                $firstImage = $animal->animalImages->sortBy('sort_order')->first();
                $imagePath = $firstImage?->image?->file_name;
                $hasImage = $imagePath && file_exists(public_path('storage/'.$imagePath));
                $imgSrc = $hasImage ? asset('storage/' . $imagePath) : asset('images/hero_shelter.png');
            @endphp
            <a href="{{ route('animals.show', $animal) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group flex flex-col">
                <div class="relative h-48 bg-gray-200 shrink-0">
                    <img src="{{ $imgSrc }}" alt="{{ $animal->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @if($index == 0)
                        <div class="absolute top-3 left-3 bg-azyl-orange text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">Nowy</div>
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $animal->breed->species->name ?? 'Zwierzę' }}</span>
                        <span class="text-[9px] font-bold bg-green-100 text-green-700 px-1.5 py-0.5 rounded-md">Dostępny</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-azyl-orange transition">{{ $animal->name }}</h3>
                    <p class="text-xs text-gray-500 mb-3">{{ $animal->breed->name ?? 'Mieszaniec' }}</p>
                    
                    <div class="flex gap-x-3 text-[10px] text-gray-600 mb-3">
                        <div class="flex items-center"><svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $animal->age_months }} mies.</div>
                        <div class="flex items-center">
                            @if($animal->genders == 0) Samiec @else Samica @endif
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-600 line-clamp-2 mb-4 flex-grow">
                        {{ $animal->description ?? 'Wspaniałe zwierzę szukające kochającego domu.' }}
                    </p>
                    
                    <span class="block w-full text-center border border-gray-200 text-gray-700 font-medium py-1.5 rounded-lg group-hover:border-azyl-orange group-hover:text-azyl-orange transition text-xs">Zobacz</span>
                </div>
            </a>
            @endforeach
            @if($recentAnimals->count() == 0)
                <p class="col-span-5 text-gray-500 text-center py-8">Brak zwierząt w katalogu.</p>
            @endif
        </div>
        <div class="mt-6 sm:hidden text-center">
            <a href="{{ route('animals.index') }}" class="text-azyl-orange font-medium hover:underline inline-flex items-center text-sm">
                Zobacz wszystkie <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
    <div class="bg-orange-50/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-1">Każda forma pomocy się liczy</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-10">Jak możesz pomóc?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition">
                    <div class="text-4xl mb-4">🏠</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Adopcja</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">
                        Daj zwierzęciu prawdziwy dom. Złóż wniosek adopcyjny i przejdź przez nasz prosty proces weryfikacji.
                    </p>
                    <a href="{{ route('animals.index') }}" class="text-azyl-orange font-medium hover:underline flex items-center text-sm mt-auto">Rozpocznij <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition">
                    <div class="text-4xl mb-4">💖</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Adopcja wirtualna</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">
                        Wspieraj finansowo konkretne zwierzę. Otrzymuj regularne aktualizacje i zdjęcia podopiecznego.
                    </p>
                    <a href="{{ route('fundraisers.index') }}" class="text-azyl-orange font-medium hover:underline flex items-center text-sm mt-auto">Wybierz podopiecznego <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Wolontariat</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">
                        Dołącz do zespołu wolontariuszy. Spacery, karmienie, socjalizacja – każda godzina jest bezcenna.
                    </p>
                    <a href="{{ url('/jak-pomoc') }}" class="text-azyl-orange font-medium hover:underline flex items-center text-sm mt-auto">Dołącz do nas <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-1">Bądź na bieżąco</p>
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Aktualności i zbiórki</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentFundraisers as $fundraiser)
            @php
                $fundraiserImg = $fundraiser->animal && $fundraiser->animal->animalImages->sortBy('sort_order')->first()
                    ? asset('storage/' . $fundraiser->animal->animalImages->sortBy('sort_order')->first()->image->file_name)
                    : asset('images/hero_shelter.png');
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                <div class="h-48 bg-gray-200">
                    <img src="{{ $fundraiserImg }}" class="w-full h-full object-cover">
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-gray-900 text-lg mb-3">{{ $fundraiser->title }}</h3>
                    
                    <div class="mt-auto">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Zebrano {{ $fundraiser->collected_amount }} zł</span>
                            <span>Cel: {{ $fundraiser->target_amount }} zł</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                            @php
                                $percent = $fundraiser->target_amount > 0 ? min(100, ($fundraiser->collected_amount / $fundraiser->target_amount) * 100) : 0;
                            @endphp
                            <div class="bg-azyl-orange h-2 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-4">{{ round($percent) }}% celu</p>
                        
                        <a href="{{ route('fundraisers.show', $fundraiser) }}" class="text-azyl-orange font-medium hover:underline text-sm inline-flex items-center">
                            Dowiedz się więcej <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                <div class="h-48 bg-gray-200">
                    <img src="{{ asset('images/hero_shelter.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Dzień Otwarty Schroniska – zapraszamy w niedzielę!</h3>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <a href="#" class="text-azyl-orange font-medium hover:underline text-sm inline-flex items-center">
                            Dowiedz się więcej <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-azyl-orange py-12">
        <div class="max-w-4xl mx-auto px-4 text-center flex flex-col items-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">Razem zmieniamy los zwierząt 🐾</h2>
            <p class="text-white/90 text-lg mb-8">
                Każdego dnia w Azylu przebywa ponad 80 zwierząt czekających na dom. Twoja decyzja może zmienić czyjeś życie.
            </p>
            <a href="{{ route('animals.index') }}" class="bg-white text-azyl-orange px-8 py-3.5 rounded-full font-bold shadow-md hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                Znajdź swojego przyjaciela
            </a>
        </div>
    </div>
@endsection
