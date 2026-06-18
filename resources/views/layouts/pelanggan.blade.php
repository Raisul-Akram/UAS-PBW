<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Portal - Bengkel Servis</title>
    
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
<body class="bg-indigo-50/30 text-slate-800 antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 text-white shrink-0 shadow-xl flex flex-col">
        <!-- Logo / Brand -->
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-2 group">
                <div class="p-2 bg-indigo-500 rounded-lg text-white font-bold transition-transform group-hover:rotate-12 duration-300">
                    BS
                </div>
                <span class="text-xl font-extrabold tracking-wider bg-gradient-to-r from-indigo-400 to-indigo-200 bg-clip-text text-transparent">
                    BENGKEL SERVIS
                </span>
            </a>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <p class="text-xs uppercase tracking-widest text-slate-500 font-semibold px-3 mb-2">Portal Pelanggan</p>
            
            <a href="{{ route('pelanggan.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('pelanggan.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pelanggan.servis.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('pelanggan.servis.index') || request()->routeIs('pelanggan.servis.show') ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Servis Saya</span>
            </a>

            <a href="{{ route('pelanggan.servis.create') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('pelanggan.servis.create') ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Ajukan Servis</span>
            </a>
        </nav>

        <!-- Footer / Logout -->
        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-colors shadow-lg shadow-red-600/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Topbar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shrink-0 shadow-sm">
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                @yield('header_title', 'Dashboard')
            </h1>
            
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full uppercase tracking-wider">
                    {{ auth()->user()->role }}
                </span>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700 hidden sm:inline">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <main class="flex-1 p-6 overflow-y-auto">
            <!-- Alert Success / Error -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-100 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
