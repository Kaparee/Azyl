<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Zadania medyczne</h2>
            <p class="text-sm text-gray-500">Dzisiaj, {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>

        @php
            $allTasks = App\Models\VolunteerTask::where('assigned_to', Auth::id())->get();
            $urgentTasks = $allTasks->where('status', 1)->take(2);
            $completed = $allTasks->where('status', 3)->count();
            $total = $allTasks->count() > 0 ? $allTasks->count() : 1;
            
            // Filtrowanie tylko dla listy
            $statusFilter = request('status');
            $tasks = $statusFilter ? $allTasks->where('status', $statusFilter) : $allTasks;
        @endphp

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
                    <div class="text-xl font-bold text-gray-900">{{ $allTasks->where('status', 1)->count() }}</div>
                    <div class="text-xs text-gray-500 mt-1">Oczekuje</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                    <div class="text-xl font-bold text-blue-600">{{ $allTasks->where('status', 2)->count() }}</div>
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
            @foreach($tasks->sortBy('time') as $task)
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
            @endforeach
        </div>
    </div>
</x-app-layout>
