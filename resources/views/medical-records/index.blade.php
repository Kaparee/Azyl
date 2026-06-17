<x-app-layout>
    <div x-data="{ showModal: false, selectedAnimalId: null, showEditModal: false, showDeleteModal: false, selectedRecord: null }" class="max-w-7xl mx-auto space-y-6 relative">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kartoteki medyczne</h2>
                <p class="text-sm text-gray-500">Dokumentacja zdrowotna wszystkich podopiecznych</p>
            </div>
            <button @click="showModal = true; selectedAnimalId = null" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 shadow-sm transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nowy wpis
            </button>
        </div>
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Animal List -->
            <div class="flex-1 space-y-4">
                @foreach($animals as $animal)
                <div x-data="{ expanded: false }" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div @click="expanded = !expanded" class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                <!-- Placeholder Image -->
                                <img src="https://ui-avatars.com/api/?name={{ $animal->name }}&background=f97316&color=fff" alt="{{ $animal->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $animal->name }} <span class="text-sm font-normal text-gray-500 ml-2">{{ $animal->breed->name ?? '' }}</span></h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ floor($animal->age_months/12) }} lat • {{ $animal->genders == 0 ? 'Pies' : 'Kot' }} • {{ $animal->medicalRecords->count() }} wpisów • Ostatnia wizyta: {{ $animal->medicalRecords->first()->treatment_date ?? 'Brak' }}
                                </p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>

                    <div x-show="expanded" style="display: none;" class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xs font-bold text-gray-500 tracking-wider">HISTORIA MEDYCZNA</h4>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('medical-records.export-pdf', $animal->id) }}" class="text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full flex items-center gap-1 hover:bg-green-200 transition-colors">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Pobierz PDF
                                </a>
                                <button @click="showModal = true; selectedAnimalId = {{ $animal->id }}" class="text-xs font-medium bg-orange-100 text-orange-600 px-3 py-1 rounded-full flex items-center gap-1 hover:bg-orange-200 transition-colors">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Dodaj wpis
                                </button>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @forelse($animal->medicalRecords as $record)
                            <div class="border border-gray-100 rounded-lg p-4 flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                                {{ $record->description }} 
                                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">{{ $record->treatment_type }}</span>
                                            </h5>
                                            <div class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                                <span>{{ $record->date_formatted }}</span>
                                                <span>Lek. weterynarii</span>
                                                <span class="font-medium text-gray-700">{{ $record->cost }} zł</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button @click="selectedRecord = {{ $record }}; showEditModal = true" class="text-orange-500 hover:text-orange-700 text-xs font-medium">Edytuj</button>
                                            <button @click="selectedRecord = {{ $record }}; showDeleteModal = true" class="text-red-500 hover:text-red-700 text-xs font-medium">Usuń</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 italic">Brak wpisów w historii medycznej.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Paginacja -->
                <div class="mt-4">
                    {{ $animals->links() }}
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="w-full lg:w-80 space-y-6">
                <!-- Filtruj Wpisy -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Filtruj wpisy</h3>
                    </div>
                    <div class="p-2 space-y-1">
                        <a href="{{ route('medical-records.index', request()->except('treatment_type')) }}" class="block {{ !request('treatment_type') ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-3 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Wszystkie typy
                        </a>
                        <a href="{{ route('medical-records.index', array_merge(request()->query(), ['treatment_type' => 'Szczepienie'])) }}" class="block {{ request('treatment_type') === 'Szczepienie' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-3">
                            💉 Szczepienie
                        </a>
                        <a href="{{ route('medical-records.index', array_merge(request()->query(), ['treatment_type' => 'Zabieg'])) }}" class="block {{ request('treatment_type') === 'Zabieg' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-3">
                            ✂️ Zabieg
                        </a>
                        <a href="{{ route('medical-records.index', array_merge(request()->query(), ['treatment_type' => 'Leki'])) }}" class="block {{ request('treatment_type') === 'Leki' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-3">
                            💊 Leki
                        </a>
                        <a href="{{ route('medical-records.index', array_merge(request()->query(), ['treatment_type' => 'Badanie'])) }}" class="block {{ request('treatment_type') === 'Badanie' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-3">
                            🩺 Badanie
                        </a>
                    </div>
                </div>

                <!-- Podsumowanie miesiąca -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Podsumowanie miesiąca</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">💉 Szczepienie</span>
                            <span class="font-bold text-green-600">2</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">💊 Leki</span>
                            <span class="font-bold text-purple-600">2</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">🩺 Badanie</span>
                            <span class="font-bold text-blue-600">3</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between">
                            <span class="text-sm font-bold text-gray-900">Łączny koszt</span>
                            <span class="text-sm font-bold text-orange-600">1445 zł</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Dodaj wpis -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Nowy wpis medyczny</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('medical-records.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Zwierzę</label>
                        <select name="animal_id" x-model="selectedAnimalId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                            <option value="">Wybierz...</option>
                            @foreach($animalsForSelect as $animal)
                                <option value="{{ $animal->id }}">{{ $animal->name }} ({{ $animal->breed->name ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data wizyty</label>
                            <input type="date" name="treatment_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Typ leczenia</label>
                            <select name="treatment_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option value="Szczepienie">Szczepienie</option>
                                <option value="Zabieg">Zabieg</option>
                                <option value="Leki">Leki</option>
                                <option value="Badanie">Badanie</option>
                                <option value="Odrobaczanie">Odrobaczanie</option>
                                <option value="Operacja">Operacja</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Opis (szczegóły)</label>
                        <textarea name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" placeholder="Wpisz przebieg wizyty, zalecenia..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Koszt (zł)</label>
                        <input type="number" step="0.01" name="cost" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" placeholder="0.00">
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600">Zapisz wpis</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showEditModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Edytuj wpis medyczny</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" :action="`/medical-records/${selectedRecord?.id}`" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data wizyty</label>
                            <input type="date" name="treatment_date" x-model="selectedRecord ? selectedRecord.treatment_date.split(' ')[0] : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Typ leczenia</label>
                            <select name="treatment_type" x-model="selectedRecord ? selectedRecord.treatment_type : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                <option value="Szczepienie">Szczepienie</option>
                                <option value="Zabieg">Zabieg</option>
                                <option value="Leki">Leki</option>
                                <option value="Badanie">Badanie</option>
                                <option value="Odrobaczanie">Odrobaczanie</option>
                                <option value="Operacja">Operacja</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Opis (szczegóły)</label>
                        <textarea name="description" rows="3" x-model="selectedRecord ? selectedRecord.description : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Koszt (zł)</label>
                        <input type="number" step="0.01" name="cost" x-model="selectedRecord ? selectedRecord.cost : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600">Zapisz zmiany</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showDeleteModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-red-600">Usuwanie wpisu</h3>
                    <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" :action="`/medical-records/${selectedRecord?.id}`" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <p class="text-sm text-gray-600">Czy na pewno chcesz bezpowrotnie usunąć ten wpis medyczny? Tej operacji nie można cofnąć.</p>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Usuń wpis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
