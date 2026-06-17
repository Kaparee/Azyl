<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up pb-12">

        <div class="relative overflow-hidden rounded-3xl bg-white border border-gray-100 shadow-sm p-8 sm:p-10">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-pink-300/20 to-orange-500/10 rounded-full blur-3xl opacity-70"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-sm font-semibold mb-4 border border-orange-100 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Ulubione
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Polubione zwierzęta</h2>
                    <p class="text-lg text-gray-600 max-w-2xl">Zwierzaki, które oznaczyłeś serduszkiem — wróć do nich i złóż wniosek adopcyjny.</p>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-2xl bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            @if($likedAnimals->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <p class="text-gray-500">Nie polubiłeś jeszcze żadnego zwierzaka.</p>
                    <a href="{{ route('animals.index') }}" class="inline-block mt-4 text-sm font-bold text-orange-500 hover:underline">Odkryj zwierzaki w schronisku &rarr;</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($likedAnimals as $animal)
                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div class="h-40 bg-gray-200 relative">
                            <x-animal-image :src="$animal->photo_url" class="w-full h-full object-cover" />
                            <form action="{{ route('animals.like', $animal) }}" method="POST" class="absolute top-3 right-3">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-red-500 hover:scale-110 shadow transition-transform">
                                    ♥
                                </button>
                            </form>
                        </div>
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">{{ $animal->breed?->species?->name ?? 'Zwierzę' }}</span>
                                    <span class="text-[9px] font-bold bg-green-100 text-green-700 px-1.5 py-0.5 rounded-md">Dostępny</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 mb-1">{{ $animal->name }}</h4>
                                <p class="text-xs text-gray-500 mb-3">{{ $animal->breed?->name ?? 'Mieszaniec' }}</p>
                            </div>
                            <a href="{{ route('animals.show', $animal) }}" class="block text-center border border-gray-200 hover:border-orange-500 hover:text-orange-500 text-gray-600 font-medium py-1.5 rounded-lg transition-colors text-xs">
                                Zobacz profil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $likedAnimals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
