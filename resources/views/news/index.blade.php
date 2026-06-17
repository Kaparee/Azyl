@extends(auth()->check() ? 'layouts.app_wrapper' : 'layouts.public')

@section('title', 'Aktualności - Azyl')

@section('content')

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 flex justify-between items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-orange-600 block mb-1">Bądź na bieżąco</span>
                    <h1 class="text-3xl font-extrabold text-gray-900">Aktualności ze schroniska</h1>
                </div>
            </div>

            @if ($news->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8 text-center text-gray-500 border border-gray-100">
                    <p class="text-lg">Brak opublikowanych aktualności.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($news as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                            <div class="h-48 bg-gray-200 relative">
                                @if ($item->image && file_exists(public_path('storage/'.$item->image)))
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/hero_shelter.png') }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <p class="text-xs text-orange-500 font-bold mb-2">{{ $item->published_at->format('d.m.Y') }}</p>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug hover:text-orange-500 transition-colors">
                                        <a href="{{ route('news.show', $item) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-6 line-clamp-3">
                                        {{ Str::limit(strip_tags($item->content), 120) }}
                                    </p>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mt-3 pt-4 border-t border-gray-50">
                                        <a href="{{ route('news.show', $item) }}" class="text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors flex items-center">
                                            Czytaj więcej
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection
