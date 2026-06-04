<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Top Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- Animals in Shelter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-green-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +12%
                    </span>
                </div>
                <div class="mt-4">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $animalsCount }}</h2>
                    <p class="text-sm font-medium text-gray-900 mt-1">Zwierząt w schronisku</p>
                    <p class="text-xs text-gray-500 mt-1">Wszystkie w bazie</p>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-red-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        -5%
                    </span>
                </div>
                <div class="mt-4">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $pendingApplicationsCount }}</h2>
                    <p class="text-sm font-medium text-gray-900 mt-1">Oczekujące wnioski</p>
                    <p class="text-xs text-gray-500 mt-1">Oczekujące na decyzję</p>
                </div>
            </div>

            <!-- Adoptions (Current Month) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $adoptionsThisMonthCount }}</h2>
                    <p class="text-sm font-medium text-gray-900 mt-1">Adopcje ({{ \Carbon\Carbon::now()->translatedFormat('F') }})</p>
                    <p class="text-xs text-gray-500 mt-1">W obecnym miesiącu</p>
                </div>
            </div>

            <!-- Virtual Adoptions Revenue -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-green-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +12%
                    </span>
                </div>
                <div class="mt-4">
                    <h2 class="text-3xl font-bold text-gray-900">{{ number_format($donationsSum, 2, ',', ' ') }} zł</h2>
                    <p class="text-sm font-medium text-gray-900 mt-1">Wirt. adopcje (mies.)</p>
                    <p class="text-xs text-gray-500 mt-1">Z obecnego miesiąca</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Adoptions) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Adopcje w ostatnich 12 miesiącach</h3>
                <div class="h-64 relative w-full">
                    <canvas id="adoptionsChart"></canvas>
                </div>
            </div>

            <!-- Donut Chart (Species) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center">
                <h3 class="text-lg font-bold text-gray-900 mb-6 w-full text-left">Zwierzęta wg gatunku</h3>
                <div class="relative w-48 h-48 mb-8">
                    <canvas id="speciesChart"></canvas>
                </div>
                <div class="w-full space-y-3">
                    @foreach($speciesLabels as $index => $label)
                    <div class="flex justify-between text-sm">
                        <span class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ ['#f97316', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#9ca3af'][$index % 6] }}"></div>
                            {{ $label }}
                        </span>
                        <span class="font-medium">{{ $animalsCount > 0 ? round(($speciesData[$index] / $animalsCount) * 100) : 0 }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pilne zadania -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Pilne zadania</h3>
            <div class="space-y-3">
                @forelse($urgentTasks as $task)
                <div class="bg-yellow-50 text-yellow-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $task->title }} – {{ $task->description }}
                    </div>
                    <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded">{{ \Carbon\Carbon::parse($task->time)->format('H:i') }}</span>
                </div>
                @empty
                <div class="text-sm text-gray-500 italic">Brak pilnych zadań do wyświetlenia.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Inicjalizacja Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wykres adopcji
            const ctxLine = document.getElementById('adoptionsChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Adopcje',
                        data: @json($monthlyAdoptions),
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#f97316',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Wykres gatunków
            const ctxDonut = document.getElementById('speciesChart').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: @json($speciesLabels),
                    datasets: [{
                        data: @json($speciesData),
                        backgroundColor: ['#f97316', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#9ca3af'],
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>
