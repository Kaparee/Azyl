<x-app-layout>
    {{-- Lista ras. Każda rasa jest pokazana razem ze swoim gatunkiem. --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Rasy</h1>
            <p class="text-sm text-slate-500">Słownik ras przypisanych do gatunków</p>
        </div>

        <a href="{{ route('admin.breeds.create') }}" class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600">
            + Dodaj rasę
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">{{ session('status') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
        <div class="mb-4 flex gap-2">
            <a href="{{ route('admin.animals.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Zwierzęta</a>
            <a href="{{ route('admin.species.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Gatunki</a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-3 py-3">Nazwa</th>
                    <th class="text-left px-3 py-3">Gatunek</th>
                    <th class="text-right px-3 py-3">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($breeds as $breed)
                    <tr class="border-t border-slate-100">
                        <td class="px-3 py-3 font-semibold">{{ $breed->name }}</td>
                        <td class="px-3 py-3">{{ $breed->species?->name }}</td>
                        <td class="px-3 py-3 text-right">
                            <a href="{{ route('admin.breeds.edit', $breed) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-semibold transition-colors">edytuj</a>

                            <form method="POST" action="{{ route('admin.breeds.destroy', $breed) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition-colors" onclick="return confirm('Usunąć rasę?')">usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-slate-500 py-6">Brak ras.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $breeds->links('vendor.pagination.admin') }}
        </div>
    </div>
</x-app-layout>
