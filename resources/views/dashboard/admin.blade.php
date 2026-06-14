<x-app-layout>
    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-[1400px] mx-auto space-y-8 animate-fade-in-up pb-12">
        
        <!-- HEADER -->
        <div class="relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-8 sm:p-10">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-orange-300/30 via-pink-300/20 to-transparent rounded-full blur-3xl opacity-70 -translate-y-1/2 translate-x-1/3"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-900 text-white text-sm font-semibold mb-4 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Centrum Dowodzenia
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Panel Administratora</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zarządzaj całym schroniskiem z jednego miejsca. Śledź statystyki, zbiórki i adopcje na bieżąco.</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.animals.index') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-bold border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all">
                        Zwierzęta
                    </a>
                    <a href="{{ route('admin.adoption-applications.index') }}" class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold shadow-lg shadow-gray-900/20 hover:bg-gray-800 transition-all">
                        Wnioski Adopcyjne
                    </a>
                </div>
            </div>
        </div>

        <!-- STATS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 text-sm font-bold {{ $animalsDiff >= 0 ? 'text-green-500' : 'text-red-500' }} bg-{{ $animalsDiff >= 0 ? 'green' : 'red' }}-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $animalsDiff >= 0 ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                        {{ abs($animalsDiff) }}%
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-1 relative z-10">{{ $animalsCount }}</h3>
                <p class="text-sm font-medium text-gray-500 relative z-10">Zwierząt w schronisku</p>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 text-sm font-bold {{ $applicationsDiff >= 0 ? 'text-green-500' : 'text-red-500' }} bg-{{ $applicationsDiff >= 0 ? 'green' : 'red' }}-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $applicationsDiff >= 0 ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                        {{ abs($applicationsDiff) }}%
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-1 relative z-10">{{ $pendingApplicationsCount }}</h3>
                <p class="text-sm font-medium text-gray-500 relative z-10">Oczekujące wnioski</p>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 text-sm font-bold {{ $adoptionsDiff >= 0 ? 'text-green-500' : 'text-red-500' }} bg-{{ $adoptionsDiff >= 0 ? 'green' : 'red' }}-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $adoptionsDiff >= 0 ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                        {{ abs($adoptionsDiff) }}%
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-1 relative z-10">{{ $adoptionsThisMonthCount }}</h3>
                <p class="text-sm font-medium text-gray-500 relative z-10">Adopcje (w tym msc)</p>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 text-sm font-bold {{ $donationsDiff >= 0 ? 'text-green-500' : 'text-red-500' }} bg-{{ $donationsDiff >= 0 ? 'green' : 'red' }}-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $donationsDiff >= 0 ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                        {{ abs($donationsDiff) }}%
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-1 relative z-10 whitespace-nowrap">{{ number_format($donationsSum, 2, ',', ' ') }} zł</h3>
                <p class="text-sm font-medium text-gray-500 relative z-10">Zbiórki (w tym msc)</p>
            </div>
        </div>

        <!-- CHARTS SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- MAIN CHART -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Adopcje w ostatnich 12 miesiącach</h3>
                        <p class="text-sm text-gray-500">Trendy i skuteczność wydawania zwierząt do domów.</p>
                    </div>
                </div>
                <div class="relative h-[300px] w-full">
                    <canvas id="adoptionsChart"></canvas>
                </div>
            </div>

            <!-- PIE CHART -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 flex flex-col">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Zwierzęta wg gatunku</h3>
                    <p class="text-sm text-gray-500">Rozkład w schronisku</p>
                </div>
                <div class="flex-1 relative min-h-[250px] flex items-center justify-center">
                    <canvas id="speciesChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <!-- SKRYPTY WYKRESÓW -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Adoptions Line Chart
            const ctxLine = document.getElementById('adoptionsChart').getContext('2d');
            
            // Gradient fill
            let gradientLine = ctxLine.createLinearGradient(0, 0, 0, 300);
            gradientLine.addColorStop(0, 'rgba(255, 107, 53, 0.5)'); // FF6B35
            gradientLine.addColorStop(1, 'rgba(255, 107, 53, 0.0)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                        label: 'Adopcje',
                        data: {!! json_encode($monthlyAdoptions) !!},
                        borderColor: '#FF6B35',
                        backgroundColor: gradientLine,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#FF6B35',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                        displayColors: false,
                        cornerRadius: 8,
                    } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f3f4f6', drawBorder: false }, ticks: { padding: 10, color: '#9ca3af', font: { family: "'Inter', sans-serif" } } },
                        x: { grid: { display: false, drawBorder: false }, ticks: { color: '#9ca3af', font: { family: "'Inter', sans-serif" } } }
                    },
                    interaction: { intersect: false, mode: 'index' },
                }
            });

            // Species Doughnut Chart
            const ctxDoughnut = document.getElementById('speciesChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($speciesLabels) !!},
                    datasets: [{
                        data: {!! json_encode($speciesData) !!},
                        backgroundColor: ['#FF6B35', '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { family: "'Inter', sans-serif", size: 12 } } },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            cornerRadius: 8,
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
