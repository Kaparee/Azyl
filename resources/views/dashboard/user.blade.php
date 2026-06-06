<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Witaj na swoim panelu!</h2>
            <p class="text-gray-500 mb-6">Tutaj możesz śledzić status swoich wniosków adopcyjnych.</p>
            <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-colors">
                Przeglądaj zwierzęta
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Moje wnioski adopcyjne</h3>
            <div class="space-y-4">
                @forelse($applications as $app)
                <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-2xl">
                            {{ $app->animal->species_id == 1 ? '🐕' : '🐈' }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $app->animal->name }}</h4>
                            <p class="text-sm text-gray-500">Złożono: {{ $app->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                    <div>
                        @if($app->status->value == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Oczekujący</span>
                        @elseif($app->status->value == 'approved')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Zaakceptowany!</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Odrzucony</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">Nie złożyłeś jeszcze żadnego wniosku adopcyjnego.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
