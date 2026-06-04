<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Użytkownika') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-black text-gray-900">Witaj, {{ $user->name }}! 👋</h1>
                    <p class="text-sm text-gray-500 mt-1">Oto podsumowanie Twojej aktywności w naszym schronisku.</p>
                </div>

                <div class="bg-orange-50 rounded-xl p-4 border border-orange-100 flex items-center space-x-3 shrink-0 w-full md:w-auto">
                    <div class="p-2 bg-orange-500 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase">Twoje wsparcie łącznie</p>
                        <p class="text-lg font-black text-orange-600 font-mono">{{ number_format($user->donations->sum('amount'), 2, ',', ' ') }} zł</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Moje wnioski adopcyjne</h3>
                </div>

                @if($user->adoptionApplications->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">Nie złożyłeś jeszcze żadnego wniosku o adopcję.</p>
                        <a href="{{ route('fundraisers.index') }}" class="inline-block mt-4 text-xs font-bold text-orange-500 hover:underline">Przeglądaj zwierzęta do adopcji &rarr;</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase border-b border-gray-100">
                                    <th class="px-6 py-4">Zwierzę</th>
                                    <th class="px-6 py-4">Wysłana wiadomość</th>
                                    <th class="px-6 py-4">Data złożenia</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($user->adoptionApplications as $app)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            {{ $app->animal->name }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $app->message }}">
                                            {{ $app->message ?? 'Brak wiadomości dodatkowej' }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-xs">
                                            {{ $app->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($app->status->name === 'PENDING')
                                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Oczekujący</span>
                                            @elseif($app->status->name === 'APPROVED')
                                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Zaakceptowany</span>
                                            @elseif($app->status->name === 'REJECTED')
                                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Odrzucony</span>
                                            @else
                                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Anulowany</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Historia moich wpłat</h3>
                    <a href="{{ route('fundraisers.index') }}" class="text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors">
                        Wesprzyj kolejne zbiórki &rarr;
                    </a>
                </div>

                @if($user->donations->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">Nie dokonałeś jeszcze żadnych wpłat wspierających nasze zbiórki.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase border-b border-gray-100">
                                    <th class="px-6 py-4">Nazwa zbiórki</th>
                                    <th class="px-6 py-4">Data wpłaty</th>
                                    <th class="px-6 py-4 text-right">Kwota wpłaty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($user->donations as $donation)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            {{ $donation->fundraiser->title }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-xs">
                                            {{ $donation->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-emerald-600 font-mono">
                                            +{{ number_format($donation->amount, 2, ',', ' ') }} zł
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
