@extends('layouts.public')

@section('title', 'Kontakt - Schronisko Azyl')

@section('content')
    <!-- Hero Section -->
    <div class="bg-[#1a202c] text-white py-16 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <span class="text-azyl-orange text-xs font-bold uppercase tracking-wider mb-2 block">🐾 KONTAKT</span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                Skontaktuj się z nami
            </h1>
            <p class="mt-4 text-gray-300 text-lg max-w-2xl mx-auto font-medium">
                Masz pytania o adopcję, wolontariat lub chcesz nam po prostu podziękować? Jesteśmy tu dla Ciebie!
            </p>
        </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="bg-[#fff7f1] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Adres -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <span class="text-3xl bg-orange-100 text-azyl-orange p-3 rounded-2xl">📍</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-1">Adres</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            ul. Schroniskowa 12<br/>
                            00-001 Warszawa<br/>
                            Dzielnica Mokotów
                        </p>
                    </div>
                </div>

                <!-- Telefon -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <span class="text-3xl bg-blue-100 text-blue-500 p-3 rounded-2xl">📞</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-1">Telefon</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            +48 22 123 45 67<br/>
                            +48 500 123 456 (SMS)<br/>
                            <span class="text-xs text-gray-400">Czynny: pon-pt 9-18</span>
                        </p>
                    </div>
                </div>

                <!-- E-mail -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <span class="text-3xl bg-green-100 text-green-500 p-3 rounded-2xl">✉️</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-1">E-mail</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            kontakt@azyl.pl<br/>
                            adopcje@azyl.pl<br/>
                            wolontariat@azyl.pl
                        </p>
                    </div>
                </div>

                <!-- Godziny otwarcia -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <span class="text-3xl bg-purple-100 text-purple-500 p-3 rounded-2xl">🕒</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-1">Godziny otwarcia</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Pon – Pt: 9:00 – 18:00<br/>
                            Sobota: 10:00 – 16:00<br/>
                            Niedziela: 10:00 – 16:00
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form and Sidebar Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12 items-start">
                
                <!-- Contact Form -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 lg:col-span-2">
                    <h2 class="text-2xl font-black text-gray-900 mb-2">Napisz do nas</h2>
                    <p class="text-gray-500 text-sm mb-6">Odpiszemy w ciągu 24-48 godzin roboczych.</p>

                    <form action="mailto:kontakt@azyl.pl" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Imię i nazwisko *</label>
                                <input type="text" name="subject" required class="w-full rounded-xl border-gray-200 text-sm focus:border-azyl-orange focus:ring-azyl-orange" placeholder="Jan Kowalski">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Adres e-mail *</label>
                                <input type="email" required class="w-full rounded-xl border-gray-200 text-sm focus:border-azyl-orange focus:ring-azyl-orange" placeholder="jan@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Numer telefonu (opcjonalnie)</label>
                            <input type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-azyl-orange focus:ring-azyl-orange" placeholder="+48 500 000 000">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Wiadomość *</label>
                            <textarea name="body" required rows="5" class="w-full rounded-xl border-gray-200 text-sm focus:border-azyl-orange focus:ring-azyl-orange" placeholder="Opisz szczegółowo swoje pytanie lub zgłoszenie..."></textarea>
                            <p class="text-[10px] text-gray-400 text-right mt-1">0 / 500</p>
                        </div>

                        <div class="text-xs text-gray-500 leading-relaxed">
                            Wyrażam zgodę na przetwarzanie moich danych osobowych w celu odpowiedzi na przesłane zapytanie zgodnie z <a href="{{ url('/polityka-prywatnosci') }}" class="text-azyl-orange underline hover:text-orange-600">Polityką prywatności</a>.
                        </div>

                        <button type="submit" class="w-full bg-azyl-orange text-white py-3.5 px-6 rounded-xl font-bold hover:bg-orange-600 transition shadow-md flex items-center justify-center gap-2">
                            ✉ Wyślij wiadomość
                        </button>
                    </form>
                </div>

                <!-- Right Sidebar Details -->
                <div class="space-y-6">
                    <!-- Google Maps CTA & Details -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">
                        <span class="text-3xl block mb-3">📍</span>
                        <p class="font-bold text-gray-950 text-sm">ul. Schroniskowa 12</p>
                        <p class="text-xs text-gray-400 mt-1 mb-4">00-001 Warszawa</p>
                        <a href="https://maps.google.com" target="_blank" class="bg-azyl-orange text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-orange-600 transition inline-block">
                            Otwórz w Google Maps
                        </a>
                        
                        <div class="border-t border-gray-100 mt-6 pt-6 text-left space-y-3">
                            <h4 class="font-bold text-gray-900 text-xs uppercase tracking-wider">Jak dojechać?</h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5">🚇 Metro: Stacja Pole Mokotowskie (5 min. pieszo)</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5">🚌 Autobus: linie 131, 159 – przystanek "Schroniskowa"</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5">🚗 Parking: bezpłatny przy schronisku</p>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm mb-4">Śledź nas w social mediach</h3>
                        <div class="space-y-3">
                            <a href="https://facebook.com" target="_blank" class="flex items-center justify-between p-3 rounded-2xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                <span class="font-bold text-sm flex items-center gap-2">👤 Facebook</span>
                                <span class="text-xs text-gray-400">/AzylSchronisko</span>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="flex items-center justify-between p-3 rounded-2xl bg-pink-50 text-pink-700 hover:bg-pink-100 transition">
                                <span class="font-bold text-sm flex items-center gap-2">📷 Instagram</span>
                                <span class="text-xs text-gray-400">@azyl_schronisko</span>
                            </a>
                            <a href="https://youtube.com" target="_blank" class="flex items-center justify-between p-3 rounded-2xl bg-red-50 text-red-700 hover:bg-red-100 transition">
                                <span class="font-bold text-sm flex items-center gap-2">🎥 YouTube</span>
                                <span class="text-xs text-gray-400">Azyl TV</span>
                            </a>
                        </div>
                    </div>

                    <!-- Urgent Matters -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Pilne sprawy</span>
                        <p class="text-xs text-gray-500 mt-3 mb-4 leading-relaxed">
                            Znalazłeś/aś ranne zwierzę lub potrzebujesz natychmiastowej pomocy?
                        </p>
                        <a href="tel:+48221234567" class="bg-azyl-orange text-white text-center w-full py-2.5 rounded-xl font-bold hover:bg-orange-600 transition inline-block text-xs">
                            📞 Zadzwoń teraz
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Volunteering Banner -->
    <div class="bg-[#1a202c] text-white py-12 text-center border-t border-gray-800">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-extrabold mb-3">Chcesz zostać wolontariuszem? 🐾</h2>
            <p class="text-gray-300 text-sm mb-6 max-w-xl mx-auto">
                Dołącz do naszej ekipy wolontariuszy. Wyślij zgłoszenie przez formularz powyżej, wybierając temat „Wolontariat”.
            </p>
            <div class="flex flex-wrap justify-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1.5"><strong class="text-green-400">✓</strong> Bezpłatne szkolenie wstępne</span>
                <span class="flex items-center gap-1.5"><strong class="text-green-400">✓</strong> Elastyczny grafik</span>
                <span class="flex items-center gap-1.5"><strong class="text-green-400">✓</strong> Zaświadczenie wolontariackie</span>
            </div>
        </div>
    </div>
@endsection
