@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('animals.index') }}" class="text-slate-500">← Wróć do katalogu</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @php
                        $photos = $animal->animalImages->sortBy('sort_order');
                        $firstPhoto = $photos->first();
                        $qrLink = route('animals.qr', $animal->qr_token);
                    @endphp

                    @if ($firstPhoto && $firstPhoto->image)
                        <img src="{{ asset('storage/'.$firstPhoto->image->file_name) }}" alt="{{ $animal->name }}" class="w-full h-80 object-cover rounded-2xl">
                    @else
                        <div class="w-full h-80 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                            brak zdjęcia
                        </div>
                    @endif

                    @if ($photos->count() > 1)
                        <div class="grid grid-cols-4 gap-2 mt-3">
                            @foreach ($photos as $photo)
                                @if ($photo->image)
                                    <img src="{{ asset('storage/'.$photo->image->file_name) }}" alt="{{ $animal->name }}" class="h-20 w-full object-cover rounded-xl">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <h1 class="text-3xl font-bold">{{ $animal->name }}</h1>
                    <p class="text-slate-500">{{ $animal->breed?->species?->name }} / {{ $animal->breed?->name }}</p>

                    <div class="mt-5 space-y-2 text-sm">
                        <p><b>Wiek:</b> {{ $animal->age_months }} mies.</p>
                        <p><b>Płeć:</b> {{ $animal->genders == 0 ? 'Samiec' : 'Samica' }}</p>
                        <p><b>Wzrost:</b> {{ $animal->height }}</p>
                        <p><b>Kolor:</b> {{ $animal->color }}</p>
                        <p><b>Status:</b> {{ $animal->status?->label() }}</p>
                        <p><b>Wejścia z QR:</b> {{ $animal->click_count }}</p>
                    </div>

                    <div class="mt-5">
                        <p class="font-semibold">Kod QR</p>
                        {{-- Ten kod QR prowadzi do trasy, która nalicza wejście i pokazuje profil. --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrLink) }}" alt="QR {{ $animal->name }}" class="w-36 h-36 rounded-xl border border-slate-200 p-2 mt-2">

                        <a href="{{ $qrLink }}" class="text-blue-600 break-all text-sm block mt-2">
                            {{ $qrLink }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-4">
                <h2 class="font-bold mb-2">Opis</h2>
                <p>{{ $animal->description }}</p>

                @if ($animal->medical_info)
                    <h2 class="font-bold mt-4 mb-2">Informacje medyczne</h2>
                    <p>{{ $animal->medical_info }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
