<x-app-layout>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-orange-600 block mb-1">Bądź na
                    bieżąco</span>
                <h1 class="text-3xl font-extrabold text-gray-900">Jak możesz pomóc?</h1>
            </div>

            @if ($fundraisers->isEmpty())
                <div
                    class="bg-white overflow-hidden shadow-sm rounded-xl p-8 text-center text-gray-500 border border-gray-100">
                    <p class="text-lg">Obecnie nie prowadzimy żadnych aktywnych zbiórek.</p>
                    <p class="text-sm mt-2 text-gray-400">Dziękujemy za Twoje dotychczasowe wsparcie!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($fundraisers as $fundraiser)
                        @php
                            $percent =
                                $fundraiser->target_amount > 0
                                    ? min(
                                        100,
                                        round(($fundraiser->collected_amount / $fundraiser->target_amount) * 100),
                                    )
                                    : 0;
                        @endphp

                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                            <div class="h-48 bg-gray-200 relative">
                                @if ($fundraiser->animal && $fundraiser->animal->images && $fundraiser->animal->images->first())
                                    <img src="/storage/{{ $fundraiser->animal->images->first()->file_name }}"
                                        alt="{{ $fundraiser->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-orange-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-orange-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                @if ($fundraiser->animal)
                                    <span
                                        class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-700 shadow-sm">
                                        Dla: {{ $fundraiser->animal->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 mb-2 leading-snug hover:text-orange-500 transition-colors">
                                        <a href="{{ route('fundraisers.show', $fundraiser) }}">
                                            {{ $fundraiser->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-6 line-clamp-3">
                                        {{ $fundraiser->description }}
                                    </p>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                                        <span>Zebrano: <strong
                                                class="text-gray-900 font-bold">{{ number_format($fundraiser->collected_amount, 0, ',', ' ') }}
                                                zł</strong></span>
                                        <span>Cel: {{ number_format($fundraiser->target_amount, 0, ',', ' ') }}
                                            zł</span>
                                    </div>

                                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden mb-2">
                                        <div class="bg-orange-500 h-2 rounded-full transition-all duration-500 ease-out"
                                            style="width: {{ $percent }}%">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center mt-3">
                                        <span class="text-xs font-bold text-orange-500">{{ $percent }}%
                                            celu</span>

                                        <a href="{{ route('fundraisers.show', $fundraiser) }}"
                                            class="text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors flex items-center">
                                            Dowiedz się więcej
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $fundraisers->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
