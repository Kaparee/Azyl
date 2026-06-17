@extends(auth()->check() ? 'layouts.app_wrapper' : 'layouts.public')

@section('title', $news->title . ' - Aktualności')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('news.index') }}" class="text-gray-500 hover:text-orange-500 transition-colors flex items-center text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Wróć do aktualności
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if ($news->image && file_exists(public_path('storage/'.$news->image)))
                <div class="w-full bg-gray-100 flex justify-center">
                    <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="w-full h-auto max-h-[700px] object-contain">
                </div>
            @else
                <div class="w-full bg-gray-100 flex justify-center">
                    <img src="{{ asset('images/hero_shelter.png') }}" alt="{{ $news->title }}" class="w-full h-auto max-h-[700px] object-cover">
                </div>
            @endif

            <div class="p-8 md:p-12">
                <div class="mb-6">
                    <span class="text-orange-500 font-bold text-sm">{{ $news->published_at->format('d.m.Y H:i') }}</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">{{ $news->title }}</h1>
                </div>

                <div class="prose prose-orange max-w-none text-gray-700">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
