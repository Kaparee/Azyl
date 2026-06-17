@extends('layouts.public')

@section('title', $animal->name.' - Azyl')

@section('content')
    @php
        $photos = $animal->animalImages
            ->sortBy('id')
            ->filter(fn ($photo) => $photo->image?->file_name)
            ->values();

        $photoUrls = $photos
            ->map(fn ($photo) => asset('storage/'.$photo->image->file_name))
            ->values()
            ->all();

        $speciesName = $animal->breed?->species?->name ?? null;
        $placeholderUrl = asset(match ($speciesName) {
            'Pies' => 'images/placeholder-dog.png',
            'Kot' => 'images/placeholder-cat.png',
            default => 'images/hero_shelter.png',
        });

        $qrLink = route('animals.qr', $animal->qr_token);
        $statusValue = $animal->status?->value ?? $animal->status;
        $statusLabel = match ($statusValue) {
            0 => 'Do adopcji',
            1 => 'W trakcie',
            2 => 'Adoptowany',
            3 => 'Niedostępny',
            default => 'Brak statusu',
        };
        $statusClass = match ($statusValue) {
            0 => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
            1 => 'bg-amber-50 text-amber-700 ring-amber-100',
            2 => 'bg-sky-50 text-sky-700 ring-sky-100',
            3 => 'bg-slate-100 text-slate-600 ring-slate-200',
            default => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    @endphp

    <div class="bg-[#fff7f1] px-6 py-8 text-slate-900">
        <div class="mx-auto max-w-7xl">
            <div class="mb-5">
                <a href="{{ route('animals.index') }}" class="text-sm font-semibold text-slate-500 hover:text-orange-600">← Wróć do katalogu</a>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-2xl bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1.25fr)_420px] lg:items-start">
                <section
                    @if (count($photoUrls) > 1)
                        x-data='{ active: 0, photos: @json($photoUrls) }'
                    @endif
                    class="w-full self-start overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-orange-100"
                >
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                        @if (count($photoUrls) > 0)
                            <img
                                src="{{ $photoUrls[0] }}"
                                @if (count($photoUrls) > 1)
                                    :src="photos[active]"
                                @endif
                                alt="{{ $animal->name }}"
                                class="absolute inset-0 h-full w-full object-cover"
                                onerror="this.onerror=null; this.src='{{ $placeholderUrl }}';"
                            >
                            @if (count($photoUrls) > 1)
                                <button type="button" @click="active = active === 0 ? photos.length - 1 : active - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2.5 rounded-full hover:bg-black/70 transition backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button type="button" @click="active = active === photos.length - 1 ? 0 : active + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2.5 rounded-full hover:bg-black/70 transition backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            @endif
                        @else
                            <x-animal-image :animal="$animal" class="absolute inset-0 h-full w-full object-cover" />
                        @endif
                    </div>

                    @if (count($photoUrls) > 1)
                        <div class="grid grid-cols-4 gap-2 p-3 md:grid-cols-6">
                            @foreach ($photoUrls as $index => $url)
                                <button
                                    type="button"
                                    @click="active = {{ $index }}"
                                    class="overflow-hidden rounded-xl ring-2 transition"
                                    :class="active === {{ $index }} ? 'ring-orange-400' : 'ring-transparent hover:ring-orange-200'"
                                >
                                    <img src="{{ $url }}" alt="{{ $animal->name }}" class="aspect-square w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </section>

                <aside class="space-y-5">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-orange-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                                <h1 class="mt-3 text-4xl font-black tracking-tight">{{ $animal->name }}</h1>
                                <p class="mt-1 text-slate-500">{{ $animal->breed?->species?->name }} / {{ $animal->breed?->name }}</p>
                            </div>

                            <div class="rounded-2xl bg-orange-50 px-4 py-3 text-center text-orange-600">
                                <p class="text-xl font-black">♥ {{ $animal->liked_by_users_count ?? 0 }}</p>
                                <p class="text-xs font-semibold text-slate-500">polubień</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-orange-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Wiek</p>
                                <p class="mt-1 font-black">{{ $animal->age_months }} mies.</p>
                            </div>
                            <div class="rounded-2xl bg-orange-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Płeć</p>
                                <p class="mt-1 font-black">{{ $animal->genders == 0 ? 'Samiec' : 'Samica' }}</p>
                            </div>
                            <div class="rounded-2xl bg-orange-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Wzrost</p>
                                <p class="mt-1 font-black">{{ $animal->height }} cm</p>
                            </div>
                            <div class="rounded-2xl bg-orange-50 px-4 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Wejścia</p>
                                <p class="mt-1 font-black">{{ $animal->recent_clicks_count ?? $animal->recentClicks()->count() }}</p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-2xl bg-slate-50 px-4 py-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kolor</p>
                            <p class="mt-1 font-semibold">{{ $animal->color }}</p>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('animals.like', $animal) }}" class="mt-5">
                                @csrf
                                <button class="w-full rounded-2xl px-5 py-3 text-sm font-bold text-white shadow-sm {{ $isLiked ? 'bg-slate-900 hover:bg-slate-800' : 'bg-orange-500 hover:bg-orange-600' }}">
                                    {{ $isLiked ? 'Usuń polubienie' : 'Polub zwierzę' }}
                                </button>
                            </form>

                            {{-- Przycisk do zbiórki pokazuje się tylko jeśli jest aktywna zbiórka dla zwierzęcia. --}}
                            @if ($activeFundraiser)
                                <a href="{{ route('fundraisers.show', $activeFundraiser) }}" class="mt-3 block rounded-2xl bg-green-500 px-5 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-green-600">
                                    Wesprzyj zbiórkę
                                </a>
                            @else
                                <button disabled class="mt-3 w-full rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-500">
                                    Brak aktywnej zbiórki
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="mt-5 block rounded-2xl bg-orange-500 px-5 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-orange-600">
                                Zaloguj się, aby polubić
                            </a>
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="mt-3 block rounded-2xl bg-green-500 px-5 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-green-600">
                                Zaloguj się, aby wesprzeć zbiórkę
                            </a>
                        @endauth
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-orange-100">
                        <p class="font-bold">Kod QR profilu</p>
                        {{-- Ten kod QR prowadzi do trasy, która nalicza wejście i pokazuje profil. --}}
                        <div class="mt-4 flex gap-4">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrLink) }}" alt="QR {{ $animal->name }}" class="h-32 w-32 rounded-2xl border border-orange-100 bg-white p-2">
                            <div class="min-w-0 text-sm text-slate-500">
                                <p>Link można wydrukować lub umieścić przy boksie zwierzęcia.</p>
                                <a href="{{ $qrLink }}" class="mt-3 block break-all font-semibold text-orange-600 hover:text-orange-700">
                                    {{ $qrLink }}
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <section x-data="{ tab: 'about' }" class="mt-6 rounded-3xl bg-white shadow-sm ring-1 ring-orange-100">
                <div class="grid grid-cols-4 border-b border-slate-100 text-center text-sm font-semibold text-slate-500">
                    <button type="button" @click="tab = 'about'" class="py-4" :class="tab === 'about' ? 'border-b-2 border-orange-400 text-orange-500' : 'hover:text-orange-500'">
                        O mnie
                    </button>
                    <button type="button" @click="tab = 'history'" class="py-4" :class="tab === 'history' ? 'border-b-2 border-orange-400 text-orange-500' : 'hover:text-orange-500'">
                        Historia
                    </button>
                    <button type="button" @click="tab = 'requirements'" class="py-4" :class="tab === 'requirements' ? 'border-b-2 border-orange-400 text-orange-500' : 'hover:text-orange-500'">
                        Wymagania
                    </button>
                    <button type="button" @click="tab = 'contact'" class="py-4" :class="tab === 'contact' ? 'border-b-2 border-orange-400 text-orange-500' : 'hover:text-orange-500'">
                        Kontakt
                    </button>
                </div>

                <div class="p-6">
                    <div x-show="tab === 'about'">
                        <h2 class="text-2xl font-black">Osobowość</h2>
                        <p class="mt-3 leading-7 text-slate-600">{{ $animal->description }}</p>

                        @if ($animal->traits && count($animal->traits) > 0)
                            <h3 class="mt-6 font-black">Cechy charakteru</h3>
                            <div class="mt-3 flex flex-wrap gap-3">
                                @foreach($animal->traits as $trait)
                                    <span class="rounded-full bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600">{{ $trait }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($animal->medical_info)
                            <div class="mt-6 rounded-2xl bg-orange-50 p-5">
                                <h3 class="font-black">Informacje medyczne</h3>
                                <p class="mt-2 leading-7 text-slate-600">{{ $animal->medical_info }}</p>
                            </div>
                        @endif
                    </div>

                    <div x-show="tab === 'history'" style="display: none;">
                        <div class="relative space-y-6 pl-10 before:absolute before:left-4 before:top-2 before:h-[calc(100%-1rem)] before:w-px before:bg-orange-100">
                            <div class="relative">
                                <span class="absolute -left-10 flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 text-orange-500 ring-1 ring-orange-200">⌂</span>
                                <p class="text-xs text-slate-400">{{ $animal->arrival_date?->format('Y-m-d') }}</p>
                                <h3 class="font-black">Przyjęcie do schroniska</h3>
                                <p class="mt-1 text-sm text-slate-500">Zwierzę zostało przyjęte do schroniska Azyl i wpisane do katalogu.</p>
                            </div>

                            @forelse ($animal->medicalRecords->sortBy('treatment_date') as $record)
                                <div class="relative">
                                    <span class="absolute -left-10 flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 text-orange-500 ring-1 ring-orange-200">✓</span>
                                    <p class="text-xs text-slate-400">{{ $record->treatment_date ? \Carbon\Carbon::parse($record->treatment_date)->format('Y-m-d') : 'brak daty' }}</p>
                                    <h3 class="font-black">{{ $record->treatment_type }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ $record->description }}</p>
                                </div>
                            @empty
                                <div class="relative">
                                    <span class="absolute -left-10 flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 text-orange-500 ring-1 ring-orange-200">✓</span>
                                    <p class="text-xs text-slate-400">{{ $animal->arrival_date?->copy()->addDays(14)->format('Y-m-d') }}</p>
                                    <h3 class="font-black">Zakończenie kwarantanny</h3>
                                    <p class="mt-1 text-sm text-slate-500">Po obserwacji zwierzę zostało uznane za gotowe do adopcji.</p>
                                </div>
                            @endforelse

                            <div class="relative">
                                <span class="absolute -left-10 flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 text-orange-500 ring-1 ring-orange-200">★</span>
                                <p class="text-xs text-slate-400">{{ $animal->created_at?->format('Y-m-d') }}</p>
                                <h3 class="font-black">Profil opublikowany</h3>
                                <p class="mt-1 text-sm text-slate-500">Profil zwierzęcia został opublikowany w katalogu schroniska.</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'requirements'" style="display: none;">
                        <div class="grid gap-4 md:grid-cols-3">
                            @if ($animal->housing_conditions)
                                <div class="rounded-2xl bg-orange-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Warunki mieszkaniowe</p>
                                    <p class="mt-1 font-semibold">{{ $animal->housing_conditions }}</p>
                                </div>
                            @endif
                            @if ($animal->experience_required)
                                <div class="rounded-2xl bg-orange-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Wymagane doświadczenie</p>
                                    <p class="mt-1 font-semibold">{{ $animal->experience_required }}</p>
                                </div>
                            @endif
                            @if ($animal->daily_time_required)
                                <div class="rounded-2xl bg-orange-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Czas poświęcony dziennie</p>
                                    <p class="mt-1 font-semibold">{{ $animal->daily_time_required }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 grid gap-3 md:grid-cols-2">
                            <div class="flex items-center justify-between rounded-2xl {{ $animal->is_child_friendly ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-50 text-slate-500' }} px-4 py-3 text-sm font-semibold">
                                <span>Przyjazny dzieciom</span>
                                <span>{{ $animal->is_child_friendly ? '✓' : '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl {{ $animal->accepts_cats ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-50 text-slate-500' }} px-4 py-3 text-sm font-semibold">
                                <span>Akceptuje koty</span>
                                <span>{{ $animal->accepts_cats ? '✓' : '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl {{ $animal->accepts_dogs ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-50 text-slate-500' }} px-4 py-3 text-sm font-semibold">
                                <span>Akceptuje inne psy</span>
                                <span>{{ $animal->accepts_dogs ? '✓' : '-' }}</span>
                            </div>
                            @if ($animal->requires_responsible_caregiver)
                                <div class="flex items-center justify-between rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-600">
                                    <span>Wymaga doświadczonego opiekuna</span>
                                    <span>!</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div x-show="tab === 'contact'" style="display: none;">
                        <div class="rounded-2xl bg-orange-50 p-5">
                            <p class="font-black">Opiekun: {{ $animal->caregiver->name ?? 'Brak przypisanego opiekuna' }}</p>
                            @if ($animal->contact_phone)
                                <p class="mt-2 text-sm text-slate-600">tel. {{ $animal->contact_phone }}</p>
                            @endif
                            @if ($animal->caregiver)
                                <p class="text-sm text-slate-600">{{ $animal->caregiver->email }}</p>
                            @endif
                        </div>

                        @if ($animal->visiting_hours)
                            <p class="mt-4 text-sm text-slate-500">Godziny odwiedzin: {{ $animal->visiting_hours }}</p>
                        @endif
                        
                        @if ($animal->caregiver)
                            <a href="mailto:{{ $animal->caregiver->email }}" class="mt-5 inline-flex rounded-2xl bg-orange-500 px-5 py-3 text-sm font-bold text-white hover:bg-orange-600">
                                Umów wizytę
                            </a>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
