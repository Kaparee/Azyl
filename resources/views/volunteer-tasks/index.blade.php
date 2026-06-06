<x-app-layout>
    <div x-data="{ showTaskModal: false }" class="max-w-5xl mx-auto space-y-6 relative">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Zadania wolontariuszy</h2>
                <p class="text-sm text-gray-500">Dzisiaj, {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            @if(in_array(Auth::user()->role_id, [1, 2]))
            <button @click="showTaskModal = true" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 shadow-sm transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Zleć zadanie
            </button>
            @endif
        </div>



        <!-- Pilne Zadania -->
        @if($urgentTasks->count() > 0)
        <div class="bg-red-50 border border-red-100 rounded-xl p-4 flex gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="space-y-2 w-full">
                <h3 class="text-sm font-bold text-red-700">Pilne zadania ({{ $urgentTasks->count() }})</h3>
                <div class="space-y-1">
                    @foreach($urgentTasks as $ut)
                    <p class="text-sm text-red-700 flex items-center gap-2">
                        <span>💊</span> <span class="font-bold">{{ $ut->title }} o {{ \Carbon\Carbon::parse($ut->time)->format('H:i') }}</span>
                        <span class="text-xs opacity-80">({{ $ut->description }})</span>
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Postęp Dnia -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
            <div class="flex justify-between items-end">
                <h3 class="text-sm font-bold text-gray-900">Postęp dnia</h3>
                <span class="text-sm font-bold text-orange-500">{{ $completed }}/{{ $allTasks->count() }}</span>
            </div>
            
            <div class="w-full bg-gray-100 rounded-full h-2.5">
                <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ ($completed / $total) * 100 }}%"></div>
            </div>
            
            <div class="grid grid-cols-4 gap-4 text-center">
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="text-xl font-bold text-gray-900">{{ $statusCounts[1] ?? 0 }}</div>
                    <div class="text-xs text-gray-500 mt-1">Oczekuje</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                    <div class="text-xl font-bold text-blue-600">{{ $statusCounts[2] ?? 0 }}</div>
                    <div class="text-xs text-blue-600 mt-1">W trakcie</div>
                </div>
                <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                    <div class="text-xl font-bold text-green-600">{{ $completed }}</div>
                    <div class="text-xs text-green-600 mt-1">Wykonano</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-3 border border-yellow-100">
                    <div class="text-xl font-bold text-yellow-600">0</div>
                    <div class="text-xs text-yellow-600 mt-1">Pominięto</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex items-center gap-2 border-b border-gray-200 pb-4">
            <a href="?status=" class="{{ request('status') == '' ? 'bg-orange-500 text-white' : 'text-gray-500 hover:text-gray-700' }} px-4 py-1.5 rounded-full text-sm font-medium">Wszystkie</a>
            <a href="?status=1" class="{{ request('status') == '1' ? 'bg-orange-500 text-white' : 'text-gray-500 hover:text-gray-700' }} px-4 py-1.5 rounded-full text-sm font-medium">Oczekuje</a>
            <a href="?status=2" class="{{ request('status') == '2' ? 'bg-orange-500 text-white' : 'text-gray-500 hover:text-gray-700' }} px-4 py-1.5 rounded-full text-sm font-medium">W trakcie</a>
            <a href="?status=3" class="{{ request('status') == '3' ? 'bg-orange-500 text-white' : 'text-gray-500 hover:text-gray-700' }} px-4 py-1.5 rounded-full text-sm font-medium">Wykonano</a>
        </div>
        
        <!-- Type Filters (Usunięto, ponieważ brakuje typów zadań w bazie) -->

        <!-- Tasks List -->
        <div class="space-y-4">
            @forelse($tasks as $task)
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex gap-4 {{ $task->status == 3 ? 'opacity-60' : '' }}">
                <div class="pt-1 shrink-0">
                    @if($task->status == 3)
                        <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    @else
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300"></div>
                    @endif
                </div>
                
                <div class="flex-1 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                💊 {{ $task->title }}
                            </h4>
                            <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($task->time)->format('H:i') }} (15 min)
                                @if(in_array($task->title, ['Leki - Zeus', 'Kontrola - Cleo']))
                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] font-bold">Pilne</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($task->status == 3)
                            <div class="bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Wykonano
                            </div>
                        @else
                            <div class="bg-gray-50 text-gray-500 border border-gray-200 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Oczekuje
                            </div>
                        @endif
                    </div>
                    
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $task->description }}</p>
                    
                    @if($task->status != 3)
                    <div class="flex items-center gap-3 pt-2">
                        @if($task->status == 1)
                        <form method="POST" action="{{ route('volunteer-tasks.update', $task) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Rozpocznij
                            </button>
                        </form>
                        @elseif($task->status == 2)
                        <form method="POST" action="{{ route('volunteer-tasks.update', $task) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Zakończ (Wykonano)
                            </button>
                        </form>
                        @endif
                        
                        <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Notatka
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Brak przypisanych zadań</h3>
                <p class="text-sm text-gray-500 mt-1">Dobra robota! Masz czyste konto na ten moment.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>

        @if(in_array(Auth::user()->role_id, [1, 2]))
        <!-- Modal: Dodaj Zadanie -->
        <div x-show="showTaskModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showTaskModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Zleć nowe zadanie</h3>
                    <button @click="showTaskModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('volunteer-tasks.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tytuł zadania</label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" placeholder="Np. Spacer z Zeusem">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Przypisz wolontariusza</label>
                        <select name="assigned_to" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                            <option value="">Wybierz...</option>
                            @foreach($volunteers as $vol)
                                <option value="{{ $vol->id }}">{{ $vol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Godzina (Orientacyjna)</label>
                        <input type="time" name="time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Szczegóły (Opcjonalnie)</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" placeholder="Dodatkowe informacje dla wolontariusza..."></textarea>
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="showTaskModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Anuluj</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600">Przydziel zadanie</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
