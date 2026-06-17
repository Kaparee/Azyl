<x-app-layout>
    {{-- Formularz edycji zwierzęcia. Jest prawie taki sam jak dodawanie, tylko ma stare wartości. --}}
    <div class="max-w-4xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Edytuj zwierzę</h1>
                <a href="{{ route('admin.animals.index') }}" class="text-slate-400">x</a>
            </div>

            <form method="POST" action="{{ route('admin.animals.update', $animal) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-4 rounded-xl bg-red-100 text-red-700 px-4 py-3">
                        Popraw błędy w formularzu.
                    </div>
                @endif

                <h2 class="font-bold mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-orange-500 text-white items-center justify-center text-xs">1</span>
                    Dane podstawowe
                </h2>

                {{-- old() zostawia wpisane dane, jeśli walidacja zwróci błąd. --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1">Imię *</label>
                        <input name="name" value="{{ old('name', $animal->name) }}" class="w-full rounded-xl border-slate-200" required>
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
                                <option value="{{ $breed->id }}" @selected(old('breed_id', $animal->breed_id) == $breed->id)>
                                    {{ $breed->name }} ({{ $breed->species?->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('breed_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Wiek w miesiącach *</label>
                        <input type="number" name="age_months" value="{{ old('age_months', $animal->age_months) }}" class="w-full rounded-xl border-slate-200" required min="0" max="360">
                        @error('age_months') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Płeć *</label>
                        <select name="genders" class="w-full rounded-xl border-slate-200" required>
                            <option value="0" @selected(old('genders', $animal->genders) == 0)>Samiec</option>
                            <option value="1" @selected(old('genders', $animal->genders) == 1)>Samica</option>
                        </select>
                        @error('genders') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Rozmiar / wzrost *</label>
                        <input type="number" name="height" value="{{ old('height', $animal->height) }}" class="w-full rounded-xl border-slate-200" required min="1" max="300">
                        @error('height') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Umaszczenie / kolor *</label>
                        <input name="color" value="{{ old('color', $animal->color) }}" class="w-full rounded-xl border-slate-200" required>
                        @error('color') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Status w schronisku *</label>
                        <select name="status" class="w-full rounded-xl border-slate-200" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $animal->status?->value) == $status->value)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Data przyjęcia *</label>
                        <input type="date" name="arrival_date" value="{{ old('arrival_date', optional($animal->arrival_date)->format('Y-m-d')) }}" class="w-full rounded-xl border-slate-200" required max="{{ date('Y-m-d') }}">
                        @error('arrival_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Opłata adopcyjna *</label>
                        <input type="number" step="0.01" name="adoption_fee" value="{{ old('adoption_fee', $animal->adoption_fee) }}" class="w-full rounded-xl border-slate-200" required min="0">
                        @error('adoption_fee') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <h2 class="font-bold mt-6 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-sky-500 text-white items-center justify-center text-xs">2</span>
                    Opis charakteru
                </h2>

                {{-- Tu admin może poprawić opis i informacje medyczne zwierzęcia. --}}
                <div class="mb-4">
                    <label class="block text-sm mb-1">Krótki opis *</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border-slate-200" required>{{ old('description', $animal->description) }}</textarea>
                    @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Informacje medyczne</label>
                    <textarea name="medical_info" rows="3" class="w-full rounded-xl border-slate-200">{{ old('medical_info', $animal->medical_info) }}</textarea>
                    @error('medical_info') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <p class="text-sm text-slate-500">Token QR: {{ $animal->qr_token }}</p>

                <h2 class="font-bold mt-6 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-purple-500 text-white items-center justify-center text-xs">3</span>
                    Cechy charakteru
                </h2>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Cechy (zaznacz pasujące)</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach(['Przyjazny dzieciom', 'Zna komendy', 'Aktywny', 'Lubi opiekę', 'Nie gryzie', 'Wymaga socjalizacji', 'Spokojny', 'Płochliwy'] as $trait)
                            <label class="flex items-center gap-2 text-sm border border-slate-200 rounded-xl p-3 cursor-pointer hover:bg-slate-50 transition">
                                <input type="checkbox" name="traits[]" value="{{ $trait }}" @checked(in_array($trait, old('traits', $animal->traits ?? []))) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                                <span>{{ $trait }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <h2 class="font-bold mt-8 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-rose-500 text-white items-center justify-center text-xs">4</span>
                    Wymagania adopcyjne
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm mb-1">Warunki mieszkaniowe</label>
                        <input name="housing_conditions" value="{{ old('housing_conditions', $animal->housing_conditions) }}" class="w-full rounded-xl border-slate-200" placeholder="np. Dom z ogrodem">
                        @error('housing_conditions') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Wymagane doświadczenie</label>
                        <input name="experience_required" value="{{ old('experience_required', $animal->experience_required) }}" class="w-full rounded-xl border-slate-200" placeholder="np. Podstawowe">
                        @error('experience_required') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Czas poświęcony dziennie</label>
                        <input name="daily_time_required" value="{{ old('daily_time_required', $animal->daily_time_required) }}" class="w-full rounded-xl border-slate-200" placeholder="np. Minimum 2 godziny">
                        @error('daily_time_required') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="is_child_friendly" value="1" @checked(old('is_child_friendly', $animal->is_child_friendly)) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                        <span class="text-sm font-semibold text-slate-700">Przyjazny dzieciom</span>
                    </label>
                    <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="accepts_cats" value="1" @checked(old('accepts_cats', $animal->accepts_cats)) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                        <span class="text-sm font-semibold text-slate-700">Akceptuje koty</span>
                    </label>
                    <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="accepts_dogs" value="1" @checked(old('accepts_dogs', $animal->accepts_dogs)) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                        <span class="text-sm font-semibold text-slate-700">Akceptuje inne psy</span>
                    </label>
                    <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="requires_responsible_caregiver" value="1" @checked(old('requires_responsible_caregiver', $animal->requires_responsible_caregiver)) class="rounded border-slate-300 text-red-500 focus:ring-red-500">
                        <span class="text-sm font-semibold text-slate-700">Wymaga doświadczonego opiekuna</span>
                    </label>
                </div>

                <h2 class="font-bold mt-8 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-indigo-500 text-white items-center justify-center text-xs">5</span>
                    Kontakt z opiekunem
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm mb-1">Opiekun *</label>
                        <select name="caregiver_id" required class="w-full rounded-xl border-slate-200 tom-select" placeholder="Wybierz opiekuna...">
                            <option value="">Wybierz...</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('caregiver_id', $animal->caregiver_id) == $emp->id ? 'selected' : '' }}>{{ $emp->name }} (Pracownik)</option>
                            @endforeach
                            @foreach($volunteers as $vol)
                                <option value="{{ $vol->id }}" {{ old('caregiver_id', $animal->caregiver_id) == $vol->id ? 'selected' : '' }}>{{ $vol->name }} (Wolontariusz)</option>
                            @endforeach
                        </select>
                        @error('caregiver_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Telefon kontaktowy</label>
                        <input name="contact_phone" value="{{ old('contact_phone', $animal->contact_phone) }}" class="w-full rounded-xl border-slate-200" placeholder="np. +48 123 456 789">
                        @error('contact_phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1">Godziny odwiedzin (np. Pon-Pt 10:00-15:00)</label>
                        <input name="visiting_hours" value="{{ old('visiting_hours', $animal->visiting_hours) }}" class="w-full rounded-xl border-slate-200" placeholder="np. Pon-Pt 10:00-17:00">
                        @error('visiting_hours') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <h2 class="font-bold mt-8 mb-4">
                    <span class="inline-flex w-6 h-6 rounded-full bg-emerald-500 text-white items-center justify-center text-xs">6</span>
                    Zdjęcia
                </h2>

                {{-- Tu można ustawić kolejność zdjęć, które już są przypisane do zwierzęcia. --}}
                @if ($animal->animalImages->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        @foreach ($animal->animalImages->sortBy('sort_order') as $animalImage)
                            <div class="border border-slate-200 rounded-2xl p-3">
                                @if ($animalImage->image)
                                    <img src="{{ asset('storage/'.$animalImage->image->file_name) }}" alt="{{ $animalImage->image->original_file_name }}" class="w-full h-32 object-cover rounded-xl mb-2">
                                @endif

                                <label class="block text-sm mb-1">Kolejność</label>
                                <input type="number" name="sort_order[{{ $animalImage->id }}]" value="{{ old('sort_order.'.$animalImage->id, $animalImage->sort_order) }}" class="w-full rounded-xl border-slate-200">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 mb-4">To zwierzę nie ma jeszcze zdjęć.</p>
                @endif

                {{-- Nowe zdjęcia dopiszą się na końcu galerii. --}}
                <div class="mb-4">
                    <label class="block text-sm mb-1">Dodaj kolejne zdjęcia</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full rounded-xl border border-slate-200 p-2">
                    <p class="text-xs text-slate-500 mt-1">Możesz wybrać kilka zdjęć. Maksymalnie 5 MB na plik.</p>
                    @error('images.*') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="border-t border-slate-200 pt-4 mt-6 flex justify-end gap-2">
                    <a href="{{ route('admin.animals.index') }}" class="px-4 py-2 rounded-xl bg-slate-100">Anuluj</a>
                    <button class="px-5 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
