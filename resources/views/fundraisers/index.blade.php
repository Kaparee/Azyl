@extends(auth()->check() ? 'layouts.app_wrapper' : 'layouts.public')

@section('title', 'Zbiórki - Azyl')

@section('content')

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 flex justify-between items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-orange-600 block mb-1">Bądź na bieżąco</span>
                    <h1 class="text-3xl font-extrabold text-gray-900">Jak możesz pomóc?</h1>
                </div>
                @if($canCreateFundraiser)
                <a href="{{ route('admin.fundraisers.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold transition-colors shadow-sm">
                    + Dodaj zbiórkę
                </a>
                @endif
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
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="{{ $fundraiser->image_url }}"
                                    alt="{{ $fundraiser->title }}" class="w-full h-full object-cover">

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
                                            style="width: {{ $fundraiser->progress_percent }}%">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center mt-3">
                                        <span class="text-xs font-bold text-orange-500">{{ $fundraiser->progress_percent }}%
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

@endsection
