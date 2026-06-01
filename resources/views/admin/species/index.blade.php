@extends('layouts.admin')

@section('content')
    {{-- Lista gatunków, czyli prosty słownik do wyboru przy rasach. --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Gatunki</h1>
            <p class="text-sm text-slate-500">Słownik gatunków zwierząt</p>
        </div>

        <a href="{{ route('admin.species.create') }}" class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600">
            + Dodaj gatunek
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3">{{ session('status') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
        <div class="mb-4 flex gap-2">
            <a href="{{ route('admin.animals.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Zwierzęta</a>
            <a href="{{ route('admin.breeds.index') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-sm">Rasy</a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-3 py-3">Nazwa</th>
                    <th class="text-right px-3 py-3">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($species as $item)
                    <tr class="border-t border-slate-100">
                        <td class="px-3 py-3 font-semibold">{{ $item->name }}</td>
                        <td class="px-3 py-3 text-right">
                            <a href="{{ route('admin.species.edit', $item) }}" class="text-slate-500 hover:text-blue-600">edytuj</a>

                            <form method="POST" action="{{ route('admin.species.destroy', $item) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2 text-slate-500 hover:text-red-600" onclick="return confirm('Usunąć gatunek?')">usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-slate-500 py-6">Brak gatunków.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $species->links('vendor.pagination.admin') }}
        </div>
    </div>
@endsection
