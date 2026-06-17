@props(['src' => null, 'class' => 'w-full h-full object-cover', 'alt' => ''])

<img src="{{ $src ?? asset('images/hero_shelter.png') }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class]) }}>