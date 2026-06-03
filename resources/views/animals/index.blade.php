@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Katalog zwierząt</h1>
        </div>

        <form method="GET" action="{{ route('animals.index') }}" class="bg-white border border-slate-200 rounded-2xl p-4 mb-6">
            {{-- Filtry są zwykłymi parametrami GET, żeby działały razem z paginacją. --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm mb-1">Szukaj</label>
                    <input name="q" value="{{ request('q') }}" class="w-full rounded-xl border-slate-200" placeholder="imię albo opis">
                </div>

                <div>
                    <label class="block text-sm mb-1">Gatunek</label>
                    <select name="species_id" class="w-full rounded-xl border-slate-200">
                        <option value="">Wszystkie</option>
                        @foreach ($species as $item)
                            <option value="{{ $item->id }}" @selected(request('species_id') == $item->id)>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">Rasa</label>
                    <select name="breed_id" class="w-full rounded-xl border-slate-200">
                        <option value="">Wszystkie</option>
                        @foreach ($breeds as $breed)
                            <option value="{{ $breed->id }}" @selected(request('breed_id') == $breed->id)>
                                {{ $breed->name }} ({{ $breed->species?->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border-slate-200">
                        <option value="">Wszystkie</option>
                        <option value="0" @selected(request('status') === '0')>Dostępne</option>
                        <option value="1" @selected(request('status') === '1')>W procesie</option>
                        <option value="2" @selected(request('status') === '2')>Adoptowane</option>
                        <option value="3" @selected(request('status') === '3')>Niedostępne</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">Płeć</label>
                    <select name="genders" class="w-full rounded-xl border-slate-200">
                        <option value="">Wszystkie</option>
                        <option value="0" @selected(request('genders') === '0')>Samiec</option>
                        <option value="1" @selected(request('genders') === '1')>Samica</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">Wiek od (lata)</label>
                    <input type="number" name="age_from" value="{{ request('age_from') }}" class="w-full rounded-xl border-slate-200">
                </div>

                <div>
                    <label class="block text-sm mb-1">Wiek do (lata)</label>
                    <input type="number" name="age_to" value="{{ request('age_to') }}" class="w-full rounded-xl border-slate-200">
                </div>

                <div class="flex items-end gap-2">
                    <button class="px-5 py-2 rounded-xl bg-orange-500 text-white">Filtruj</button>
                    <a href="{{ route('animals.index') }}" class="px-5 py-2 rounded-xl bg-slate-100">Wyczyść</a>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($animals as $animal)
                @php
                    $firstImage = $animal->animalImages->sortBy('sort_order')->first();
                @endphp

                <div class="bg-white border border-slate-200 rounded-2xl p-4">
                    @if ($firstImage && $firstImage->image)
                        <img src="{{ asset('storage/'.$firstImage->image->file_name) }}" alt="{{ $animal->name }}" class="w-full h-44 object-cover rounded-xl mb-3">
                    @else
                        <div class="w-full h-44 bg-slate-100 rounded-xl mb-3 flex items-center justify-center text-slate-400">
                            brak zdjęcia
                        </div>
                    @endif

                    <h2 class="font-bold text-lg">{{ $animal->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $animal->breed?->species?->name }} / {{ $animal->breed?->name }}</p>
                    <p class="text-sm mt-2">{{ $animal->age_months }} mies. | wejścia: {{ $animal->click_count }}</p>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('animals.show', $animal) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm">Szczegóły</a>
                        <a href="{{ route('animals.qr', $animal->qr_token) }}" class="px-4 py-2 rounded-xl bg-slate-100 text-sm">Link QR</a>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-200 rounded-2xl p-6 text-slate-500">
                    Nie znaleziono zwierząt.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $animals->links('vendor.pagination.admin') }}
        </div>
    </div>
@endsection
