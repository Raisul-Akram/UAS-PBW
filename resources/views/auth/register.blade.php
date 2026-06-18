<x-guest-layout>
    <div class="mb-6 space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900">Daftar Akun Baru</h2>
        <p class="text-xs text-slate-500">Mulai daftarkan akun pelanggan Anda untuk mengajukan servis.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <label for="name" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Contoh: Budi Santoso"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('name') border-rose-500 @enderror">
            @error('name')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="budi@gmail.com"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor HP -->
        <div class="space-y-1.5">
            <label for="no_hp" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Nomor HP / WhatsApp</label>
            <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 08123456789"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('no_hp') border-rose-500 @enderror">
            <p class="text-xxs text-slate-400 mt-0.5">Format nomor HP Indonesia diawali 08 (10-13 digit).</p>
            @error('no_hp')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="space-y-1.5">
            <label for="alamat" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Alamat Rumah Lengkap</label>
            <textarea id="alamat" name="alamat" required rows="3" placeholder="Masukkan alamat lengkap tempat tinggal Anda..."
                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('alamat') border-rose-500 @enderror">{{ old('alamat') }}</textarea>
            @error('alamat')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <label for="password" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('password') border-rose-500 @enderror">
            @error('password')
                <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <label for="password_confirmation" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password"
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30">
                Daftar Akun
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-3 border-t border-slate-100">
            <p class="text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-750 font-bold transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
