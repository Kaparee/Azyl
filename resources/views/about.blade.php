@extends('layouts.public')

@section('title', 'Schronisko Azyl - O nas')

@section('content')
    <div class="relative bg-gray-900 min-h-[500px] flex flex-col justify-center items-center text-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero_shelter.png') }}" alt="Pies ze schroniska" class="w-full h-full object-cover opacity-50">
        </div>

        <div class="relative z-10 max-w-3xl px-4 mt-8 flex flex-col items-center">
            <div class="text-azyl-orange text-sm font-bold uppercase tracking-widest mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                O NAS
            </div>
            
            <h1 class="text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                20 lat miłości <br/>
                <span class="text-azyl-orange">do zwierząt</span>
            </h1>
            
            <p class="mt-6 text-lg text-gray-200 max-w-2xl font-medium">
                Schronisko Azyl powstało z potrzeby serca. Od 2004 roku dajemy drugą szansę bezdomnym zwierzętom i pomagamy im znaleźć kochające domy.
            </p>
            
            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="#" class="bg-azyl-orange text-white px-8 py-3.5 rounded-full font-semibold hover-bg-azyl-orange transition flex items-center justify-center gap-2 shadow-lg">
                    Poznaj nasze zwierzęta
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="#" class="bg-transparent text-white border border-white/40 px-8 py-3.5 rounded-full font-semibold hover:bg-white/10 transition flex items-center justify-center">
                    Jak możesz pomóc
                </a>
            </div>
        </div>
    </div>
    <div class="bg-white border-b border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div class="flex flex-col items-center">
                    <div class="text-3xl mb-2">🏠</div>
                    <p class="text-2xl font-extrabold text-azyl-orange">150+</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Szczęśliwych adopcji</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-3xl mb-2">📅</div>
                    <p class="text-2xl font-extrabold text-azyl-orange">20 lat</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Służymy zwierzętom</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-3xl mb-2">🤝</div>
                    <p class="text-2xl font-extrabold text-azyl-orange">45+</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Aktywnych wolontariuszy</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-3xl mb-2">🐾</div>
                    <p class="text-2xl font-extrabold text-azyl-orange">80+</p>
                    <p class="text-sm font-medium text-gray-500 mt-1">Zwierząt pod opieką</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-20 bg-orange-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div>
                    <span class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2 block">Nasza misja</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl leading-tight">
                        Każde zwierzę zasługuje na miłość
                    </h2>
                    <p class="mt-6 text-base text-gray-600 leading-relaxed">
                        Schronisko Azyl to certyfikowana placówka zajmująca się ratowaniem, rehabilitacją i adopcją zwierząt bezdomnych w Warszawie i okolicach. Działamy od 2004 roku, kierując się przekonaniem, że każde życie jest cenne.
                    </p>
                    <p class="mt-4 text-base text-gray-600 leading-relaxed">
                        Nasz zespół – złożony z doświadczonych opiekunów, lekarzy weterynarii i ponad 45 wolontariuszy – każdego dnia dba o dobrostan ponad 80 zwierząt przebywających pod naszą opieką.
                    </p>
                    <p class="mt-4 text-base text-gray-600 leading-relaxed">
                        Wierzymy w odpowiedzialne adopcje. Nasz proces weryfikacyjny nie jest barierą, lecz gwarancją, że każde zwierzę trafi do odpowiedniego domu, dopasowanego do jego potrzeb i charakteru.
                    </p>

                    <div class="mt-8 flex gap-12 border-t border-gray-200 pt-8">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Fundacja zarejestrowana</p>
                            <p class="font-bold text-gray-900">KRS 0000123456</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mb-1">Certyfikat PTOZ</p>
                            <p class="font-bold text-gray-900">Nr 2016/045</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0 relative">
                    <div class="aspect-w-4 aspect-h-3 rounded-3xl overflow-hidden shadow-lg border border-gray-100">
                        <img src="{{ asset('images/hero_shelter.png') }}" alt="Pies i kot" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-2xl shadow-xl border border-gray-50 flex items-center gap-4">
                        <div class="w-14 h-14 bg-azyl-orange rounded-full flex items-center justify-center text-white shadow-inner">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-gray-900">4.9/5</p>
                            <p class="text-xs text-gray-500 font-medium">Ocena adopcyjnych rodzin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2">Co nas wyróżnia</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Nasze wartości</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-orange-100 text-azyl-orange rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Miłość i szacunek</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Każde zwierzę traktujemy z troską i godnością, niezależnie od jego historii i stanu zdrowia.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Profesjonalizm</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Działamy zgodnie z najwyższymi standardami opieki weterynaryjnej i behawioralnej.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-green-100 text-green-500 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Wspólnota</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Budujemy sieć wolontariuszy, adopcyjnych rodzin i darczyńców połączonych miłością do zwierząt.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-purple-100 text-purple-500 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Dom dla każdego</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Wierzymy, że każde zwierzę zasługuje na ciepły dom i kochającą rodzinę.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2">Nasza droga</p>
                <h2 class="text-3xl font-bold text-gray-900">Historia schroniska</h2>
            </div>

            <div class="relative border-l border-gray-200 ml-3 md:ml-1/2">
                <div class="hidden md:block absolute w-px h-full bg-orange-200 left-1/2 transform -translate-x-1/2"></div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 text-right md:pr-8 mb-4 md:mb-0">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2004</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">Założenie schroniska</h3>
                        <p class="text-gray-500 text-sm mt-2">Azyl powstał jako odpowiedź na rosnącą liczbę bezdomnych zwierząt w Warszawie.</p>
                    </div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12"></div>
                </div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 hidden md:block"></div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12 md:pl-8 mb-4 md:mb-0">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2008</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">Pierwsze 100 adopcji</h3>
                        <p class="text-gray-500 text-sm mt-2">Osiągnęliśmy przełomowy milestone – 100 zwierząt znalazło nowe domy.</p>
                    </div>
                </div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 text-right md:pr-8 mb-4 md:mb-0">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2012</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">Rozbudowa placówki</h3>
                        <p class="text-gray-500 text-sm mt-2">Dzięki wsparciu darczyńców otworzyliśmy nowy pawilon dla kotów i gabinet weterynaryjny.</p>
                    </div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12"></div>
                </div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 hidden md:block"></div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12 md:pl-8 mb-4 md:mb-0">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2016</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">Certyfikat jakości</h3>
                        <p class="text-gray-500 text-sm mt-2">Uzyskaliśmy certyfikat Polskiego Towarzystwa Ochrony Zwierząt za standardy opieki.</p>
                    </div>
                </div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 text-right md:pr-8 mb-4 md:mb-0">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2020</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">Program wirtualnych adopcji</h3>
                        <p class="text-gray-500 text-sm mt-2">Uruchomiliśmy platformę adopcji wirtualnych, która pozwala wspierać konkretne zwierzęta.</p>
                    </div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12"></div>
                </div>
                <div class="mb-10 flex flex-col md:flex-row justify-between items-center w-full">
                    <div class="order-1 w-full md:w-5/12 hidden md:block"></div>
                    <div class="z-20 flex items-center order-1 bg-white border-4 border-orange-100 shadow-sm w-4 h-4 rounded-full bg-azyl-orange hidden md:flex"></div>
                    <div class="order-1 w-full md:w-5/12 md:pl-8">
                        <span class="bg-azyl-orange text-white text-xs font-bold px-3 py-1 rounded-full">2024</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2">System Azyl online</h3>
                        <p class="text-gray-500 text-sm mt-2 font-medium">Wdrożenie nowoczesnego systemu zarządzania schroniskiem – transparentność i wygoda dla wszystkich.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="py-20 bg-orange-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2">Ludzie za sukcesem</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nasz zespół</h2>
            <p class="text-gray-500 max-w-2xl mx-auto mb-12">Pasjonaci z doświadczeniem, którzy każdego dnia wstają rano z myślą o zwierzętach pod ich opieką.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center">
                    <div class="w-20 h-20 bg-azyl-orange text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4">MW</div>
                    <h3 class="font-bold text-gray-900 text-lg">Marta Wiśniewska</h3>
                    <p class="text-xs text-azyl-orange font-bold uppercase mb-4">Dyrektor Schroniska</p>
                    <p class="text-xs text-gray-500 text-center leading-relaxed">Z pasją do zwierząt od ponad 15 lat. Odpowiada za strategię placówki i koordynację całego zespołu.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center">
                    <div class="w-20 h-20 bg-[#4F8B8B] text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4">TK</div>
                    <h3 class="font-bold text-gray-900 text-lg">Tomasz Kowalczyk</h3>
                    <p class="text-xs text-[#4F8B8B] font-bold uppercase mb-4">Kierownik ds. Adopcji</p>
                    <p class="text-xs text-gray-500 text-center leading-relaxed">Pomógł przeprowadzić ponad 300 adopcji. Ekspert w dopasowywaniu zwierząt do rodzin.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center">
                    <div class="w-20 h-20 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4">AZ</div>
                    <h3 class="font-bold text-gray-900 text-lg">Anna Zielińska</h3>
                    <p class="text-xs text-green-500 font-bold uppercase mb-4">Lekarz Weterynarii</p>
                    <p class="text-xs text-gray-500 text-center leading-relaxed">Czuwa nad zdrowiem wszystkich podopiecznych. Specjalizuje się w medycynie wewnętrznej małych zwierząt.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center">
                    <div class="w-20 h-20 bg-purple-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mb-4">PN</div>
                    <h3 class="font-bold text-gray-900 text-lg">Piotr Nowak</h3>
                    <p class="text-xs text-purple-500 font-bold uppercase mb-4">Koordynator Wolontariuszy</p>
                    <p class="text-xs text-gray-500 text-center leading-relaxed">Zarządza ponad 45 wolontariuszami. Tworzy harmonogramy i dba o ich szkolenie i motywację.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6">Partnerzy i patroni</p>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">PTOZ</div>
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">TOZ Warszawa</div>
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">Fundacja Przyjazny Dom</div>
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">Miasto Warszawa</div>
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">Zoo Warszawa</div>
                <div class="px-6 py-3 border border-gray-200 text-gray-500 text-sm font-medium rounded-full shadow-sm hover:border-gray-300 transition">Klub Zoologiczny</div>
            </div>
        </div>
    </div>
    <div class="bg-azyl-orange py-16">
        <div class="max-w-4xl mx-auto px-4 text-center flex flex-col items-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">Dołącz do rodziny Azylu 🐾</h2>
            <p class="text-white/90 text-lg mb-8 font-medium">
                Adoptuj, wolontariatem lub darowizną – każda forma wsparcia zmienia czyjeś życie.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/') }}" class="bg-white text-azyl-orange px-8 py-3.5 rounded-full font-bold shadow-md hover:bg-gray-50 transition">
                    Znajdź zwierzę
                </a>
                <a href="#" class="bg-transparent text-white border border-white/50 px-8 py-3.5 rounded-full font-bold hover:bg-white/10 transition">
                    Jak pomóc?
                </a>
            </div>
        </div>
    </div>

@endsection
