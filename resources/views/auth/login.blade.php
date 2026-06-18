<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-500">Silakan masuk menggunakan akun terdaftar Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('password') border-rose-500 @enderror">
            @error('password')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center select-none cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-350 rounded focus:ring-indigo-500/20">
                <span class="ms-2 text-xs font-semibold text-slate-500">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30">
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-3 border-t border-slate-100">
            <p class="text-xs text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-750 font-bold transition-colors">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
