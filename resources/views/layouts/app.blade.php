<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Azyl') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex w-full h-screen overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-8 relative">
                    <!-- Global Toasts -->
                    @if(session('success') || session('error'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                             class="absolute top-4 right-8 z-50 transition-all duration-300 transform"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            
                            @if(session('success'))
                                <div class="bg-green-50 text-green-800 border border-green-200 rounded-xl p-4 shadow-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-medium text-sm">{{ session('success') }}</span>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="bg-red-50 text-red-800 border border-red-200 rounded-xl p-4 shadow-lg flex items-center gap-3">
                                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-medium text-sm">{{ session('error') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <style>
            .ts-control { border-radius: 0.75rem; border-color: #e2e8f0; padding: 0.5rem 0.75rem; }
            .ts-dropdown { border-radius: 0.75rem; overflow: hidden; border-color: #e2e8f0; }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll("select").forEach(function(el) {
                    if (!el.classList.contains("tomselected")) {
                        new TomSelect(el, {
                            create: false,
                            sortField: { field: "text", direction: "asc" }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
