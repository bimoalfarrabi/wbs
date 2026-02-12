<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="min-h-screen bg-slate-100 font-sans antialiased flex flex-col items-center justify-center p-4">
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex flex-col items-center">
            <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan" class="h-20 w-auto mb-4">
            <h1 class="text-2xl font-bold text-slate-900">Whistleblowing System</h1>
            <p class="text-slate-500">RSUD Blambangan Banyuwangi</p>
        </a>
    </div>

    <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl overflow-hidden">
        @yield('content')
    </div>

    <div class="mt-8 text-slate-500 text-sm">
        &copy; {{ date('Y') }} RSUD Blambangan
    </div>
</body>

</html>
