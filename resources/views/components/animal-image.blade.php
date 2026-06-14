@props(['animal', 'class' => 'w-full h-full object-cover', 'alt' => null])

@php
    $firstImage = $animal->animalImages->sortBy('sort_order')->first();
    $imagePath = $firstImage?->image?->file_name;
    $hasImage = $imagePath && file_exists(public_path('storage/' . $imagePath));

    $speciesName = $animal->breed?->species?->name ?? null;
    $fallback = match ($speciesName) {
        'Pies' => 'images/placeholder-dog.png',
        'Kot' => 'images/placeholder-cat.png',
        default => 'images/hero_shelter.png',
    };
    if (! file_exists(public_path($fallback))) {
        $fallback = 'images/hero_shelter.png';
    }

    $imgSrc = $hasImage ? asset('storage/' . $imagePath) : asset($fallback);
    $altText = $alt ?? $animal->name;
@endphp

<img src="{{ $imgSrc }}" alt="{{ $altText }}" {{ $attributes->merge(['class' => $class]) }}>
