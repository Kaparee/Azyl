<x-app-layout>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('fundraisers.index') }}"
                    class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Powrót do wszystkich zbiórek
                </a>
            </div>

            @php
                $percent =
                    $fundraiser->target_amount > 0
                        ? min(100, round(($fundraiser->collected_amount / $fundraiser->target_amount) * 100))
                        : 0;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h1 class="text-2xl font-black text-gray-900 mb-4">{{ $fundraiser->title }}</h1>

                        <div class="prose max-w-none text-gray-600 text-sm leading-relaxed mb-6">
                            {{ $fundraiser->description }}
                        </div>

                        @if ($fundraiser->animal)
                            <div
                                class="bg-orange-50/50 rounded-xl p-4 border border-orange-100 flex items-center space-x-4">
                                <div
                                    class="w-16 h-16 bg-orange-200 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">Zbiórka dedykowana dla:
                                        {{ $fundraiser->animal->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Wiek: {{ $fundraiser->animal->age_months }}
                                        miesięcy | Płeć: {{ $fundraiser->animal->genders == 1 ? 'Samiec' : 'Samica' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Postęp zbiórki</h3>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="text-gray-500">Zebrano</span>
                                <span
                                    class="font-bold text-gray-900">{{ number_format($fundraiser->collected_amount, 2, ',', ' ') }}
                                    zł</span>
                            </div>
                            <div class="flex justify-between text-sm mb-4">
                                <span class="text-gray-500">Cel zbiórki</span>
                                <span
                                    class="font-bold text-gray-900">{{ number_format($fundraiser->target_amount, 2, ',', ' ') }}
                                    zł</span>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="bg-orange-500 h-3 rounded-full transition-all duration-500 ease-out"
                                    style="width: {{ $percent }}%">
                                </div>
                            </div>
                            <div class="text-right text-xs font-bold text-orange-500 mt-1.5">
                                {{ $percent }}% celu
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-50 text-green-700 text-xs rounded-lg border border-green-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('donation.store') }}" method="POST"
                            class="space-y-4 pt-4 border-t border-gray-100">
                            @csrf
                            <input type="hidden" name="fundraiser_id" value="{{ $fundraiser->id }}">

                            <div>
                                <label for="amount" class="block text-xs font-bold text-gray-700 uppercase mb-1">Kwota
                                    wsparcia (zł)</label>
                                <input type="number" name="amount" id="amount" min="1" step="0.01"
                                    required
                                    class="w-full rounded-lg border-gray-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 text-sm"
                                    placeholder="Wpisz kwotę, np. 50">
                                @error('amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="anonymous" id="anonymous" value="1"
                                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500 h-4 w-4">
                                <label for="anonymous" class="ml-2 text-xs text-gray-600">Chcę wpłacić anonimowo</label>
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition-colors duration-200 text-center">
                                Wesprzyj teraz
                            </button>
                        </form>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Ostatnie wpłaty</h3>

                        @if ($fundraiser->donations->isEmpty())
                            <p class="text-xs text-gray-400 text-center py-4">Bądź pierwszą osobą, która wesprze tę
                                zbiórkę!</p>
                        @else
                            <div class="space-y-3">
                                @foreach ($fundraiser->donations->take(5) as $donation)
                                    <div
                                        class="flex justify-between items-center text-xs py-2 border-b border-gray-50 last:border-0">
                                        <div>
                                            <p class="font-bold text-gray-800">
                                                {{ $donation->user_id && $donation->user ? $donation->user->name : 'Anonimowy darczyńca' }}
                                            </p>
                                            <p class="text-gray-400 text-[10px]">
                                                {{ $donation->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span
                                            class="font-bold text-emerald-600 font-mono">+{{ number_format($donation->amount, 2, ',', ' ') }}
                                            zł</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
