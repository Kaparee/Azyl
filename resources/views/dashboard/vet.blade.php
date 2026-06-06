<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Panel Weterynarza</h2>
            <p class="text-gray-500">Zarządzaj zdrowiem pacjentów schroniska.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                <h3 class="text-xl font-bold text-blue-900 mb-2">Pod opieką: {{ $patientsCount }} zwierząt</h3>
                <p class="text-blue-700 text-sm">Wszyscy podopieczni w systemie gotowi na przegląd medyczny.</p>
                <a href="{{ route('medical-records.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Przejdź do kartotek</a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Zlecenia medyczne (dla wolontariuszy)</h3>
                <div class="space-y-3">
                    @forelse($medicalTasks as $task)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="text-red-500">💊</span>
                            <span class="font-medium text-sm text-gray-800">{{ $task->title }}</span>
                        </div>
                        <span class="text-xs text-gray-500">Wydane o: {{ \Carbon\Carbon::parse($task->time)->format('H:i') }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic">Brak zleceń medycznych w toku.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
