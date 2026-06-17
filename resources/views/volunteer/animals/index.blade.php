<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Katalog zwierząt</h1>
            <p class="text-sm text-slate-500">Przeglądaj zwierzęta w schronisku (tryb podglądu)</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-3 py-3">Zwierzę</th>
                        <th class="text-left px-3 py-3">Gatunek</th>
                        <th class="text-left px-3 py-3">Wiek</th>
                        <th class="text-left px-3 py-3">Status</th>
                        <th class="text-right px-3 py-3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($animals as $animal)
                        <tr class="border-t border-slate-100">
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0">
                                        <x-animal-image :src="$animal->photo_url" class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $animal->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $animal->breed?->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-slate-600">{{ $animal->breed?->species?->name }}</td>
                            <td class="px-3 py-3 text-slate-600">
                                @if($animal->age_months)
                                    @if($animal->age_months >= 12)
                                        {{ floor($animal->age_months / 12) }} lat
                                    @else
                                        {{ $animal->age_months }} mies.
                                    @endif
                                @else
                                    Nieznany
                                @endif
                            </td>
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
                            <td class="px-3 py-3 text-right">
                                <a href="{{ route('animals.show', $animal) }}" class="text-orange-500 hover:text-orange-600 font-bold">Pokaż profil &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-slate-400">Brak zwierząt do wyświetlenia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $animals->links() }}
        </div>
    </div>
</x-app-layout>
