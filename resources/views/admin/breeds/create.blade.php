@extends('layouts.admin')

@section('content')
    {{-- Formularz dodawania rasy do wybranego gatunku. --}}
    <div class="max-w-xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h1 class="text-xl font-bold">Dodaj rasę</h1>
            </div>

            <form method="POST" action="{{ route('admin.breeds.store') }}" class="p-6">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nazwa rasy *</label>
                    <input name="name" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200" placeholder="np. Labrador Retriever" required>
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Gatunek *</label>
                    <select name="species_id" class="w-full rounded-xl border-slate-200" required>
                        <option value="">-- wybierz --</option>
                        @foreach ($species as $item)
                            <option value="{{ $item->id }}" @selected(old('species_id') == $item->id)>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('species_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.breeds.index') }}" class="px-4 py-2 rounded-xl bg-slate-100">Anuluj</a>
                    <button class="px-5 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
@endsection
