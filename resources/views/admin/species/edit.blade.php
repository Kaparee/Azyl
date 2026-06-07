@extends('layouts.admin')

@section('content')
    {{-- Formularz zmiany nazwy gatunku. --}}
    <div class="max-w-xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h1 class="text-xl font-bold">Edytuj gatunek</h1>
            </div>

            <form method="POST" action="{{ route('admin.species.update', $species) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nazwa gatunku *</label>
                    <input name="name" value="{{ old('name', $species->name) }}" class="w-full rounded-xl border-slate-200" required>
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.species.index') }}" class="px-4 py-2 rounded-xl bg-slate-100">Anuluj</a>
                    <button class="px-5 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
@endsection
