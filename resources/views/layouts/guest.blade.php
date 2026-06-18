<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bengkel Servis') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-6">
        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <a href="/" class="inline-flex items-center gap-2.5 justify-center group">
                <div class="p-3 bg-indigo-600 rounded-2xl text-white font-extrabold text-xl shadow-lg shadow-indigo-600/30 transition-transform group-hover:rotate-12 duration-300">
                    BS
                </div>
                <span class="text-2xl font-extrabold tracking-wider bg-gradient-to-r from-indigo-700 to-violet-850 bg-clip-text text-transparent">
                    BENGKEL SERVIS
                </span>
            </a>
            <p class="text-slate-500 text-sm">Sistem Lacak & Manajemen Perbaikan Perangkat</p>
        </div>

        <!-- Floating Card -->
        <div class="bg-white/80 backdrop-blur-md p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-2xl shadow-slate-100 overflow-hidden relative">
            <!-- Decorative light source -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>
            
            {{ $slot }}
        </div>
        
        <!-- Footer Info -->
        <div class="text-center">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Bengkel Servis. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
