<x-app-layout>
    {{-- Formularz dodawania zwierzęcia razem ze zdjęciami do galerii. --}}
    <div class="max-w-4xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Dodaj nowe zwierzę</h1>
                <a href="{{ route('admin.animals.index') }}" class="text-slate-400">x</a>
            </div>

            <form method="POST" action="{{ route('admin.animals.store') }}" class="p-6" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 rounded-xl bg-red-100 text-red-700 px-4 py-3">
                        Popraw błędy w formularzu.
                    </div>
                @endif

                <h2 class="font-bold mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-orange-500 text-white items-center justify-center text-xs">1</span>
                    Dane podstawowe
                </h2>

                {{-- Pola odpowiadają kolumnom, które już są w tabeli animals. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1">Imię *</label>
                        <input name="name" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200" placeholder="np. Max" required>
                        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm">Rasa *</label>
                            <a href="{{ route('admin.breeds.index') }}" target="_blank" class="text-xs text-blue-500 hover:text-blue-700 font-medium">+ dodaj nową rasę</a>
                        </div>
                        <select name="breed_id" class="w-full rounded-xl border-slate-200" required>
                            <option value="">-- wybierz --</option>
                            @foreach ($breeds as $breed)
                                <option value="{{ $breed->id }}" @selected(old('breed_id') == $breed->id)>
                                    {{ $breed->name }} ({{ $breed->species?->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('breed_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Wiek w miesiącach *</label>
                        <input type="number" name="age_months" value="{{ old('age_months') }}" class="w-full rounded-xl border-slate-200" placeholder="np. 36" required>
                        @error('age_months') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Płeć *</label>
                        <select name="genders" class="w-full rounded-xl border-slate-200" required>
                            <option value="0" @selected(old('genders') === '0')>Samiec</option>
                            <option value="1" @selected(old('genders') === '1')>Samica</option>
                        </select>
                        @error('genders') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Rozmiar / wzrost *</label>
                        <input type="number" name="height" value="{{ old('height') }}" class="w-full rounded-xl border-slate-200" placeholder="np. 45" required>
                        @error('height') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Umaszczenie / kolor *</label>
                        <input name="color" value="{{ old('color') }}" class="w-full rounded-xl border-slate-200" placeholder="np. Złoty" required>
                        @error('color') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Status w schronisku *</label>
                        <select name="status" class="w-full rounded-xl border-slate-200" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(old('status') == $status->value)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Data przyjęcia *</label>
                        <input type="date" name="arrival_date" value="{{ old('arrival_date', now()->format('Y-m-d')) }}" class="w-full rounded-xl border-slate-200" required>
                        @error('arrival_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Opłata adopcyjna *</label>
                        <input type="number" step="0.01" name="adoption_fee" value="{{ old('adoption_fee', 0) }}" class="w-full rounded-xl border-slate-200" required>
                        @error('adoption_fee') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <h2 class="font-bold mt-6 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-sky-500 text-white items-center justify-center text-xs">2</span>
                    Opis charakteru
                </h2>

                {{-- Opis i informacje medyczne są zwykłymi polami tekstowymi. --}}
                <div class="mb-4">
                    <label class="block text-sm mb-1">Krótki opis *</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border-slate-200" placeholder="Krótki opis zwierzęcia..." required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Informacje medyczne</label>
                    <textarea name="medical_info" rows="3" class="w-full rounded-xl border-slate-200" placeholder="Zdrowie, leczenie, uwagi...">{{ old('medical_info') }}</textarea>
                    @error('medical_info') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <h2 class="font-bold mt-6 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-green-500 text-white items-center justify-center text-xs">3</span>
                    Zdjęcia
                </h2>

                {{-- Można wybrać kilka plików naraz, a sortowanie będzie według kolejności uploadu. --}}
                <div class="mb-4">
                    <label class="block text-sm mb-1">Zdjęcia zwierzęcia</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full rounded-xl border border-slate-200 p-2">
                    <p class="text-xs text-slate-500 mt-1">Możesz wybrać kilka zdjęć. Maksymalnie 5 MB na plik.</p>
                    @error('images.*') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="border-t border-slate-200 pt-4 mt-6 flex justify-end gap-2">
                    <a href="{{ route('admin.animals.index') }}" class="px-4 py-2 rounded-xl bg-slate-100">Anuluj</a>
                    <button class="px-5 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600">Dodaj zwierzę</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
