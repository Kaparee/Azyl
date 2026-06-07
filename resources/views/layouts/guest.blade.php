<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex w-full">
            <!-- Left Side - Image -->
            <div class="hidden lg:flex w-[720px] flex-shrink-0 bg-gray-900 text-white flex-col justify-end p-12 relative overflow-hidden">
                @php
                    $bgImage = request()->routeIs('register') ? 'register_foto.png' : 'login_foto.png';
                @endphp
                <div class="absolute inset-0 bg-black opacity-40 z-10"></div>
                <div class="absolute inset-0 z-0" style="background-image: url('{{ asset('images/' . $bgImage) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                <!-- Optional background image can be added in specific views -->
                <div class="z-20 relative">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Azyl Logo" class="h-12 w-auto">
                        <h1 class="text-3xl font-bold">Azyl</h1>
                    </div>
                    <blockquote class="text-4xl font-semibold mb-2 leading-tight">"Każde zwierzę zasługuje na dom pełen miłości."</blockquote>
                    <p class="text-lg text-gray-300">— Schronisko Azyl od 2004 roku</p>
                </div>
            </div>

            <!-- Right Side - Content -->
            <div class="flex-1 flex items-center justify-center p-8 bg-orange-50/50">
                <div class="w-full max-w-2xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
