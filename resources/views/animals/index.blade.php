@extends('layouts.public')

@section('title', 'Zwierzęta - Azyl')

@section('content')
    <div class="bg-[#fff7f1] py-10 text-slate-900">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-8">
                <p class="text-sm font-semibold uppercase tracking-wide text-orange-500">Katalog adopcyjny</p>
                <div class="mt-2 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                    <div>
                        <h1 class="text-4xl font-black tracking-tight">Nasze zwierzaki</h1>
                    </div>

                    <div class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-600 shadow-sm ring-1 ring-orange-100">
                        Wyniki: <span class="text-orange-600">{{ $animals->total() }}</span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
                <aside>
                    <form method="GET" action="{{ route('animals.index') }}" class="sticky top-6 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-orange-100">
                        <!-- Filtry są zwykłymi parametrami GET, żeby działały razem z paginacją. -->
                        <div class="mb-5 flex items-center justify-between">
                            <h2 class="text-lg font-bold">Filtry</h2>
                            <a href="{{ route('animals.index') }}" class="text-xs font-semibold text-orange-500 hover:text-orange-600">Wyczyść</a>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Szukaj</label>
                                <input name="q" value="{{ request('q') }}" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400" placeholder="imię albo opis">
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Gatunek</label>
                                <select name="species_id" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400">
                                    <option value="">Wszystkie</option>
                                    @foreach ($species as $item)
                                        <option value="{{ $item->id }}" @selected(request('species_id') == $item->id)>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Rasa</label>
                                <select name="breed_id" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400">
                                    <option value="">Wszystkie</option>
                                    @foreach ($breeds as $breed)
                                        <option value="{{ $breed->id }}" @selected(request('breed_id') == $breed->id)>
                                            {{ $breed->name }} ({{ $breed->species?->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
                                <select name="status" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400">
                                    <option value="" @selected($statusFilter === null)>Do adopcji (domyślnie)</option>
                                    <option value="all" @selected($statusFilter === 'all')>Wszystkie</option>
                                    <option value="0" @selected($statusFilter === '0')>Do adopcji</option>
                                    <option value="1" @selected($statusFilter === '1')>W trakcie</option>
                                    <option value="2" @selected($statusFilter === '2')>Adoptowane</option>
                                    <option value="3" @selected($statusFilter === '3')>Niedostępne</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Płeć</label>
                                <select name="genders" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400">
                                    <option value="">Wszystkie</option>
                                    <option value="0" @selected(request('genders') === '0')>Samiec</option>
                                    <option value="1" @selected(request('genders') === '1')>Samica</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Wiek od</label>
                                    <input type="number" name="age_from" value="{{ request('age_from') }}" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400" placeholder="lata">
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Wiek do</label>
                                    <input type="number" name="age_to" value="{{ request('age_to') }}" class="w-full rounded-2xl border-slate-200 text-sm focus:border-orange-400 focus:ring-orange-400" placeholder="lata">
                                </div>
                            </div>

                            <button class="w-full rounded-2xl bg-orange-500 px-5 py-3 font-semibold text-white shadow-sm hover:bg-orange-600">
                                Filtruj zwierzęta
                            </button>
                        </div>
                    </form>
                </aside>

                <section>
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($animals as $animal)
                            <article class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-orange-100 transition hover:-translate-y-1 hover:shadow-xl">
                                <div class="relative">
                                    <img src="{{ $animal->photo_url }}" alt="{{ $animal->name }}" class="h-56 w-full object-cover">

                                    <div class="absolute left-4 top-4 rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $animal->status_class }}">
                                        {{ $animal->status_label }}
                                    </div>

                                    <div class="absolute right-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-orange-500 shadow-sm">
                                        ♥ {{ $animal->liked_by_users_count ?? 0 }}
                                    </div>
                                </div>

                                <div class="p-5">
                                    <div>
                                        <h2 class="text-xl font-black">{{ $animal->name }}</h2>
                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $animal->breed?->species?->name }} / {{ $animal->breed?->name }}
                                        </p>
                                    </div>

                                    <p class="mt-4 line-clamp-2 text-sm leading-6 text-slate-600">
                                        {{ $animal->description }}
                                    </p>

                                    <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                                        <div class="rounded-2xl bg-orange-50 px-2 py-3">
                                            <p class="font-bold text-slate-900">{{ $animal->age_months }}</p>
                                            <p class="text-slate-500">mies.</p>
                                        </div>
                                        <div class="rounded-2xl bg-orange-50 px-2 py-3">
                                            <p class="font-bold text-slate-900">{{ $animal->gender_label }}</p>
                                            <p class="text-slate-500">płeć</p>
                                        </div>
                                        <div class="rounded-2xl bg-orange-50 px-2 py-3">
                                            <p class="font-bold text-slate-900">{{ $animal->recent_clicks_count ?? 0 }}</p>
                                            <p class="text-slate-500">wejścia</p>
                                        </div>
                                    </div>

                                    <a href="{{ route('animals.qr', $animal->qr_token) }}" class="mt-5 block rounded-2xl bg-orange-500 px-4 py-3 text-center text-sm font-bold text-white hover:bg-orange-600">
                                        Zobacz profil
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-3xl bg-white p-8 text-slate-500 shadow-sm ring-1 ring-orange-100">
                                Nie znaleziono zwierząt.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $animals->links('vendor.pagination.admin') }}
                    </div>
                </section>
            </div>
        </div>

    </div>
@endsection
