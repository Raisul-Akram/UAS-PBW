@extends('layouts.admin')

@section('header_title', 'Edit Pelanggan ' . $pelanggan->user->name)

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.pelanggan.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Edit Data Pelanggan</h2>
            <p class="text-sm text-slate-500">Perbarui informasi kontak, nama lengkap, atau alamat pelanggan.</p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form method="POST" action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="space-y-1.5">
                <label for="name" class="text-sm font-semibold text-slate-700">Nama Pelanggan <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $pelanggan->user->name) }}" placeholder="Contoh: Budi Santoso"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-sm font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $pelanggan->user->email) }}" placeholder="Contoh: budi@gmail.com"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="space-y-1.5">
                <label for="no_hp" class="text-sm font-semibold text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" placeholder="Contoh: 081234567890"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('no_hp') border-rose-500 @enderror">
                <p class="text-xs text-slate-400 mt-0.5">Harus diawali 08 dan memiliki panjang 10-13 karakter.</p>
                @error('no_hp')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="space-y-1.5">
                <label for="alamat" class="text-sm font-semibold text-slate-700">Alamat Lengkap <span class="text-rose-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap rumah/kantor pelanggan..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('alamat') border-rose-500 @enderror">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.pelanggan.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">Batal</a>
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
