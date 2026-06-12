<x-app-layout>
    {{-- Widok listy zwierząt w panelu admina. --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Zarządzanie zwierzętami</h1>
            <p class="text-sm text-slate-500">Lista zwierząt dodanych do schroniska</p>
        </div>

        <a href="{{ route('admin.animals.create') }}" class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600">
            + Dodaj zwierzę
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    {{-- Małe kafelki z podsumowaniem statusów. --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-green-50 rounded-2xl text-center p-4">
            <div class="text-2xl font-bold text-green-600">{{ $availableCount }}</div>
            <div class="text-xs text-slate-500">Dostępne</div>
        </div>
        <div class="bg-orange-50 rounded-2xl text-center p-4">
            <div class="text-2xl font-bold text-orange-500">{{ $pendingCount }}</div>
            <div class="text-xs text-slate-500">W procesie</div>
        </div>
        <div class="bg-red-50 rounded-2xl text-center p-4">
            <div class="text-2xl font-bold text-red-500">{{ $unavailableCount }}</div>
            <div class="text-xs text-slate-500">Niedostępne</div>
        </div>
        <div class="bg-purple-50 rounded-2xl text-center p-4">
            <div class="text-2xl font-bold text-purple-600">{{ $adoptedCount }}</div>
            <div class="text-xs text-slate-500">Adoptowane</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
        {{-- Pole szukania jest na razie tylko wyglądem, filtrowanie będzie w późniejszym punkcie. --}}
        <div class="flex items-center justify-between gap-3 mb-4">
            <input class="w-full max-w-sm rounded-xl border-slate-200 text-sm" placeholder="Szukaj po imieniu, rasie, gatunku...">

            <div class="flex gap-2">
                <a href="{{ route('admin.species.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Gatunki</a>
                <a href="{{ route('admin.breeds.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Rasy</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-3 py-3">Zwierzę</th>
                        <th class="text-left px-3 py-3">Gatunek</th>
                        <th class="text-left px-3 py-3">Wiek</th>
                        <th class="text-left px-3 py-3">Status</th>
                        <th class="text-left px-3 py-3">Opiekun</th>
                        <th class="text-left px-3 py-3">Data przyjęcia</th>
                        <th class="text-right px-3 py-3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($animals as $animal)
                        @php
                            $firstImage = $animal->animalImages->sortBy('sort_order')->first();
                        @endphp

                        <tr class="border-t border-slate-100">
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($firstImage && $firstImage->image)
                                        <img src="{{ asset('storage/'.$firstImage->image->file_name) }}" alt="{{ $animal->name }}" loading="lazy" decoding="async" width="40" height="40" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                                            {{ strtoupper(substr($animal->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold">{{ $animal->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $animal->breed?->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3">{{ $animal->breed?->species?->name }}</td>
                            <td class="px-3 py-3">{{ floor($animal->age_months / 12) }} lat</td>
                            <td class="px-3 py-3">
                                @if ($animal->status?->value === 0)
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">{{ $animal->status?->label() }}</span>
                                @elseif ($animal->status?->value === 1)
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">{{ $animal->status?->label() }}</span>
                                @elseif ($animal->status?->value === 2)
                                    <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs">{{ $animal->status?->label() }}</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">{{ $animal->status?->label() }}</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">-</td>
                            <td class="px-3 py-3">{{ optional($animal->arrival_date)->format('Y-m-d') }}</td>
                            <td class="px-3 py-3 text-right">
                                <a href="{{ route('admin.animals.edit', $animal) }}" class="text-slate-500 hover:text-blue-600">edytuj</a>

                                <form method="POST" action="{{ route('admin.animals.destroy', $animal) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="ml-2 text-slate-500 hover:text-red-600" onclick="return confirm('Usunąć zwierzę?')">usuń</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-slate-500 py-6">Nie ma jeszcze zwierząt.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $animals->links('vendor.pagination.admin') }}
        </div>
    </div>
</x-app-layout>
