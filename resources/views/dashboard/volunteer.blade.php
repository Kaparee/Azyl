<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-orange-500 rounded-xl shadow-sm border border-orange-600 p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Panel Wolontariusza</h2>
            <p class="text-orange-100">Witaj ponownie! Sprawdź swoje dzisiejsze zadania.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $completedToday }}</h3>
                    <p class="text-sm text-gray-500">Zrobione dziś</p>
                </div>
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">✓</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pending }}</h3>
                    <p class="text-sm text-gray-500">Oczekujące</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl">!</div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $tasks->where('status', 3)->count() }}</h3>
                    <p class="text-sm text-gray-500">Wszystkie wykonane</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl">★</div>
            </div>
        </div>

        <div class="text-center py-6">
            <a href="{{ route('volunteer-tasks.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-bold text-lg shadow-lg inline-block transition-transform hover:-translate-y-1">Przejdź do Planu Dnia</a>
        </div>
    </div>
</x-app-layout>
