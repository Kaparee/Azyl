<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Panel Pracownika</h2>
            <p class="text-gray-500">Zarządzaj zwierzętami i wnioskami adopcyjnymi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $animalsCount }}</h3>
                <p class="text-gray-500 text-sm">Zwierząt w schronisku</p>
                <!-- Oczekujący widok na zarządzanie zwierzętami -->
                <button class="mt-4 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium w-full">Katalog zwierząt</button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $pendingApplicationsCount }}</h3>
                <p class="text-gray-500 text-sm">Oczekujące wnioski adopcyjne</p>
                <button class="mt-4 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium w-full">Przejrzyj wnioski</button>
            </div>
        </div>
    </div>
</x-app-layout>
