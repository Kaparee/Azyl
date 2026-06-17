<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-8 animate-fade-in-up py-12">
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Edytuj zbiórkę</h2>
            
            <form action="{{ route('admin.fundraisers.update', $fundraiser) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Tytuł zbiórki *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $fundraiser->title) }}" required
                        class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm"
                        placeholder="Np. Pomoc dla bezdomnego Reksia">
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Opis *</label>
                    <textarea id="description" name="description" rows="5" required
                        class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm"
                        placeholder="Napisz kilka słów, dlaczego organizujesz tę zbiórkę...">{{ old('description', $fundraiser->description) }}</textarea>
                </div>

                <div>
                    <label for="animal_id" class="block text-sm font-bold text-gray-700 mb-2">Zwierzę *</label>
                    <select id="animal_id" name="animal_id" required class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm tom-select">
                        <option value="">Wybierz zwierzę...</option>
                        @foreach($animals as $animal)
                            <option value="{{ $animal->id }}" @selected($animal->id == $fundraiser->animal_id)>{{ $animal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_amount" class="block text-sm font-bold text-gray-700 mb-2">Cel zbiórki (zł) *</label>
                        <input type="number" id="target_amount" name="target_amount" min="1" step="0.01" value="{{ old('target_amount', $fundraiser->target_amount) }}" required
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm"
                            placeholder="1000">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">Data zakończenia (opcjonalnie)</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $fundraiser->end_date ? \Carbon\Carbon::parse($fundraiser->end_date)->format('Y-m-d') : '') }}" min="{{ date('Y-m-d') }}"
                            class="w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>
                </div>

                <div class="pt-6 flex justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('fundraisers.show', $fundraiser) }}" class="px-6 py-3 rounded-xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                        Anuluj
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl font-bold text-white bg-orange-500 hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
