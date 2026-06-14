@extends('layouts.public')

@section('title', 'Jak pomóc - Schronisko Azyl')

@section('content')
    <!-- Hero Section -->
    <div class="bg-[#1a202c] text-white py-16 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <span class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2 block">🐾 JAK POMÓC</span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                Razem możemy więcej
            </h1>
            <p class="mt-4 text-gray-300 text-lg max-w-2xl mx-auto font-medium">
                Istnieje wiele sposobów, żeby wesprzeć schronisko Azyl i podopieczne zwierzęta. Każda forma pomocy – duża czy mała – ma ogromne znaczenie.
            </p>
        </div>
    </div>

    <!-- Main Content Tabs Section -->
    <div class="bg-[#fff7f1] py-12" x-data="{ activeTab: 'adoption' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tab buttons -->
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                <button @click="activeTab = 'adoption'" :class="activeTab === 'adoption' ? 'bg-azyl-orange text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'" class="px-5 py-2.5 rounded-full font-bold text-sm shadow-sm transition flex items-center gap-2">
                    🏠 Adopcja
                </button>
                <button @click="activeTab = 'virtual'" :class="activeTab === 'virtual' ? 'bg-azyl-orange text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'" class="px-5 py-2.5 rounded-full font-bold text-sm shadow-sm transition flex items-center gap-2">
                    💖 Adopcja wirtualna
                </button>
                <button @click="activeTab = 'volunteering'" :class="activeTab === 'volunteering' ? 'bg-azyl-orange text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'" class="px-5 py-2.5 rounded-full font-bold text-sm shadow-sm transition flex items-center gap-2">
                    🤝 Wolontariat
                </button>
                <button @click="activeTab = 'donations'" :class="activeTab === 'donations' ? 'bg-azyl-orange text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'" class="px-5 py-2.5 rounded-full font-bold text-sm shadow-sm transition flex items-center gap-2">
                    💰 Darowizna
                </button>
                <button @click="activeTab = 'material'" :class="activeTab === 'material' ? 'bg-azyl-orange text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'" class="px-5 py-2.5 rounded-full font-bold text-sm shadow-sm transition flex items-center gap-2">
                    📦 Zbiórki rzeczowe
                </button>
            </div>

            <!-- Tab Content Pane: Adoption -->
            <div x-show="activeTab === 'adoption'" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-2xl flex items-center justify-center text-2xl mb-6">🏠</div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Adopcja</h2>
                        <p class="text-azyl-orange text-sm font-bold mb-4">Daj zwierzęciu prawdziwy dom</p>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            Adopcja to najpiękniejszy akt miłości wobec bezdomnego zwierzęcia. Zapewniasz mu stały dom, troskę i bezpieczeństwo na całe życie.
                        </p>
                        <ol class="space-y-4 mb-6">
                            <li class="flex gap-3 text-sm text-gray-600">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-azyl-orange flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">1</span>
                                <span>Przeglądaj profile zwierząt i wybierz swojego kandydata.</span>
                            </li>
                            <li class="flex gap-3 text-sm text-gray-600">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-azyl-orange flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">2</span>
                                <span>Złóż wniosek adopcyjny online (ok. 10 minut).</span>
                            </li>
                            <li class="flex gap-3 text-sm text-gray-600">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-azyl-orange flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">3</span>
                                <span>Nasz zespół skontaktuje się z Tobą w ciągu 48h.</span>
                            </li>
                            <li class="flex gap-3 text-sm text-gray-600">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-azyl-orange flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">4</span>
                                <span>Umów wizytę zapoznawczą w schronisku.</span>
                            </li>
                            <li class="flex gap-3 text-sm text-gray-600">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-azyl-orange flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">5</span>
                                <span>Podpisz umowę adopcyjną i zabierz nowego przyjaciela do domu!</span>
                            </li>
                        </ol>
                    </div>
                    <a href="{{ route('animals.index') }}" class="bg-azyl-orange text-white text-center py-3.5 px-6 rounded-xl font-bold hover:bg-orange-600 transition inline-block shadow-md">
                        Przeglądaj zwierzęta →
                    </a>
                </div>

                <div class="space-y-6 flex flex-col justify-between">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex-grow">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="text-azyl-orange">🔔</span> Dlaczego warto?
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-center gap-2">✓ Zwierzęta adoptowane żyją dłużej i zdrowiej</li>
                            <li class="flex items-center gap-2">✓ Pełne wsparcie naszego zespołu przez cały rok</li>
                            <li class="flex items-center gap-2">✓ Bezpłatna konsultacja behawioralna po adopcji</li>
                        </ul>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-2xl font-black text-azyl-orange">150+</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Adopcji rocznie</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-2xl font-black text-azyl-orange">48h</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Czas odpowiedzi</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-2xl font-black text-azyl-orange">98%</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Zadowolonych rodzin</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🗓️</span>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">Masz pytania?</p>
                                <p class="text-xs text-gray-500">Skontaktuj się z nami</p>
                            </div>
                        </div>
                        <a href="{{ url('/kontakt') }}" class="text-azyl-orange font-bold text-sm hover:underline">Przejdź do kontaktu →</a>
                    </div>
                </div>
            </div>

            <!-- Tab Content Pane: Virtual Adoption -->
            <div x-show="activeTab === 'virtual'" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100" style="display: none;">
                <div class="max-w-3xl">
                    <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-2xl flex items-center justify-center text-2xl mb-6">💖</div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Adopcja wirtualna</h2>
                    <p class="text-azyl-orange text-sm font-bold mb-4">Wspieraj na odległość</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Jeśli nie możesz adoptować fizycznie, zaopiekuj się zwierzakiem wirtualnie. Pokrywasz koszty wyżywienia, opieki weterynaryjnej lub leczenia wybranego podopiecznego schroniska.
                    </p>
                    <a href="{{ route('fundraisers.index') }}" class="bg-azyl-orange text-white py-3.5 px-8 rounded-xl font-bold hover:bg-orange-600 transition inline-block shadow-md">
                        Wybierz podopiecznego do adopcji wirtualnej
                    </a>
                </div>
            </div>

            <!-- Tab Content Pane: Volunteering -->
            <div x-show="activeTab === 'volunteering'" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100" style="display: none;">
                <div class="max-w-3xl">
                    <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-2xl flex items-center justify-center text-2xl mb-6">🤝</div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Wolontariat</h2>
                    <p class="text-azyl-orange text-sm font-bold mb-4">Podaruj swój czas i serce</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Wolontariat w Azylu to spacery z psami, socjalizacja kotów, pomoc w pracach porządkowych, a także reprezentowanie schroniska podczas dni otwartych i wydarzeń edukacyjnych. Szukamy osób odpowiedzialnych, pełnoletnich, kochających zwierzęta.
                    </p>
                    <a href="{{ route('register') }}" class="bg-azyl-orange text-white py-3.5 px-8 rounded-xl font-bold hover:bg-orange-600 transition inline-block shadow-md">
                        Zarejestruj się jako wolontariusz
                    </a>
                </div>
            </div>

            <!-- Tab Content Pane: Donations -->
            <div x-show="activeTab === 'donations'" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100" style="display: none;">
                <div class="max-w-3xl">
                    <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-2xl flex items-center justify-center text-2xl mb-6">💰</div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Darowizna finansowa</h2>
                    <p class="text-azyl-orange text-sm font-bold mb-4">Pomóż finansować leki i specjalistyczną karmę</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Każda złotówka przekazana na nasze konto pozwala nam kupować specjalistyczną karmę weterynaryjną, opłacać skomplikowane operacje chirurgiczne i dbać o bieżące potrzeby schroniska.
                    </p>
                    <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-6">
                        <p class="text-sm font-bold text-gray-900 mb-2">Dane do przelewu:</p>
                        <p class="text-sm text-gray-700">Fundacja Azyl</p>
                        <p class="text-sm text-gray-700">Nr konta: <strong class="text-slate-900">12 1234 5678 9012 3456 7890 1234</strong></p>
                        <p class="text-sm text-gray-700">Tytuł przelewu: <strong>Darowizna dla Azylu</strong></p>
                    </div>
                </div>
            </div>

            <!-- Tab Content Pane: Material Help -->
            <div x-show="activeTab === 'material'" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100" style="display: none;">
                <div class="max-w-3xl">
                    <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-2xl flex items-center justify-center text-2xl mb-6">📦</div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Zbiórki rzeczowe</h2>
                    <p class="text-azyl-orange text-sm font-bold mb-4">Podziel się karmą lub akcesoriami</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Przyjmujemy wysokiej jakości karmę (suchą i mokrą), legowiska, smycze, obroże, zabawki, a także środki czystości (płyny do podłóg, ręczniki papierowe). Zobacz poniżej nasze aktualne potrzeby i dowiedz się, jak dostarczyć dary.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Current Needs Section -->
    <div class="bg-white py-16 border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2 block">AKTUALNE POTRZEBY</span>
                <h2 class="text-3xl font-bold text-gray-900">Co teraz potrzebujemy?</h2>
                <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">
                    Poniżej aktualne braki w zapasach schroniska. Każda dostarczona paczka ma realne znaczenie dla naszych podopiecznych.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Karma sucha -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🍗</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Karma sucha dla psów</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 30% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-bold">Potrzebne</span>
                </div>
                <!-- Karma mokra -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🐟</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Karma mokra dla kotów</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 45% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-orange-100 text-orange-700 px-2.5 py-1 rounded-full font-bold">Potrzebne</span>
                </div>
                <!-- Leki -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">💊</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Leki weterynaryjne</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 15% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-bold">Pilne!</span>
                </div>
                <!-- Legowiska -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🛏️</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Legowiska i posłania</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 60% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-bold">Przydatne</span>
                </div>
                <!-- Srodki czystosci -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🧼</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Środki czystości</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 70% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-bold">Przydatne</span>
                </div>
                <!-- Zabawki -->
                <div class="border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🎾</span>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Zabawki i gryzaki</h3>
                            <p class="text-xs text-gray-500 mt-1">Zapas: 80% normy</p>
                        </div>
                    </div>
                    <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-bold">Chętnie</span>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/kontakt') }}" class="bg-azyl-orange text-white px-8 py-3.5 rounded-xl font-bold hover:bg-orange-600 transition inline-block shadow-md">
                    Umów dostawę →
                </a>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-[#fff7f1] py-16">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2 block">PYTANIA I ODPOWIEDZI</span>
                <h2 class="text-3xl font-bold text-gray-900">Najczęstsze pytania</h2>
            </div>

            <div class="space-y-4" x-data="{ faq: null }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <button @click="faq = faq === 1 ? null : 1" class="w-full px-6 py-4 text-left font-bold text-gray-900 hover:text-azyl-orange transition flex justify-between items-center text-sm">
                        <span>Czy adopcja jest płatna?</span>
                        <span x-text="faq === 1 ? '▲' : '▼'" class="text-xs text-gray-400"></span>
                    </button>
                    <div x-show="faq === 1" class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-50 pt-4">
                        Pobieramy symboliczną opłatę adopcyjną (adoption fee), która pokrywa ułamek kosztów szczepień, sterylizacji i czipowania zwierzaka. Dokładna kwota zależy od zwierzęcia i jest widoczna na jego profilu.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <button @click="faq = faq === 2 ? null : 2" class="w-full px-6 py-4 text-left font-bold text-gray-900 hover:text-azyl-orange transition flex justify-between items-center text-sm">
                        <span>Jak długo trwa proces adopcji?</span>
                        <span x-text="faq === 2 ? '▲' : '▼'" class="text-xs text-gray-400"></span>
                    </button>
                    <div x-show="faq === 2" class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-50 pt-4">
                        Zwykle cały proces od złożenia wniosku do podpisania umowy i odbioru zwierzaka trwa od 5 do 14 dni, w zależności od liczby spacerów zapoznawczych niezbędnych dla danego psa czy kota.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <button @click="faq = faq === 3 ? null : 3" class="w-full px-6 py-4 text-left font-bold text-gray-900 hover:text-azyl-orange transition flex justify-between items-center text-sm">
                        <span>Czy mogę odwiedzić schronisko bez umówienia?</span>
                        <span x-text="faq === 3 ? '▲' : '▼'" class="text-xs text-gray-400"></span>
                    </button>
                    <div x-show="faq === 3" class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-50 pt-4">
                        Zalecamy wcześniejszy kontakt telefoniczny lub mailowy, by nasi opiekunowie mogli poświęcić Państwu pełną uwagę oraz przygotować wybrane zwierzęta do spotkania.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <button @click="faq = faq === 4 ? null : 4" class="w-full px-6 py-4 text-left font-bold text-gray-900 hover:text-azyl-orange transition flex justify-between items-center text-sm">
                        <span>Jak zostać wolontariuszem?</span>
                        <span x-text="faq === 4 ? '▲' : '▼'" class="text-xs text-gray-400"></span>
                    </button>
                    <div x-show="faq === 4" class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-50 pt-4">
                        Wystarczy zarejestrować się w naszym systemie jako Wolontariusz. Po weryfikacji konta otrzymasz zaproszenie na szkolenie wprowadzające i BHP.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA -->
    <div class="bg-azyl-orange py-16 text-center text-white">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-extrabold mb-4">Gotowy, żeby pomóc? 🐾</h2>
            <p class="text-white/90 text-lg mb-8 max-w-xl mx-auto">
                Wybierz formę wsparcia, która pasuje do Twoich możliwości. Każde działanie ma znaczenie.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('animals.index') }}" class="bg-white text-azyl-orange px-8 py-3.5 rounded-full font-bold shadow-md hover:bg-gray-50 transition">
                    Adoptuj zwierzę
                </a>
                <a href="{{ url('/kontakt') }}" class="bg-transparent text-white border border-white/50 px-8 py-3.5 rounded-full font-bold hover:bg-white/10 transition">
                    Skontaktuj się z nami
                </a>
            </div>
        </div>
    </div>
@endsection
