<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel admina</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    {{-- Prosty layout pod strony admina. Navbar i sidebar mają być dodane osobno. --}}
    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
