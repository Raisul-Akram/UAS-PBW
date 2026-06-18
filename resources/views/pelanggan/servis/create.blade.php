@extends('layouts.pelanggan')

@section('header_title', 'Ajukan Servis Baru')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('pelanggan.servis.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Form Pengajuan Servis</h2>
            <p class="text-sm text-slate-500">Ajukan perbaikan perangkat Anda secara online. Teknisi kami akan mendiagnosis kerusakan setelah perangkat diterima.</p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form method="POST" action="{{ route('pelanggan.servis.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Perangkat -->
            <div class="space-y-1.5">
                <label for="nama_perangkat" class="text-sm font-semibold text-slate-700">Nama/Merek Perangkat <span class="text-rose-500">*</span></label>
                <input type="text" id="nama_perangkat" name="nama_perangkat" value="{{ old('nama_perangkat') }}" placeholder="Contoh: Laptop HP Pavilion 14 / iPhone 11 Pro"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('nama_perangkat') border-rose-500 @enderror">
                <p class="text-xs text-slate-400 mt-0.5">Tulis nama lengkap tipe perangkat secara spesifik.</p>
                @error('nama_perangkat')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kerusakan -->
            <div class="space-y-1.5">
                <label for="jenis_kerusakan" class="text-sm font-semibold text-slate-700">Gejala & Deskripsi Kerusakan <span class="text-rose-500">*</span></label>
                <textarea id="jenis_kerusakan" name="jenis_kerusakan" rows="5" placeholder="Tuliskan secara lengkap gejala kerusakan (contoh: mati total setelah terkena tumpahan air / layar bergaris-garis / keyboard tidak berfungsi sebagian)..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none @error('jenis_kerusakan') border-rose-500 @enderror">{{ old('jenis_kerusakan') }}</textarea>
                @error('jenis_kerusakan')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notice Box -->
            <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl text-xs text-indigo-800 leading-relaxed space-y-1">
                <p class="font-bold">⚠️ Catatan Pendaftaran Online:</p>
                <p>1. Status awal otomatis **ANTRI**. Setelah mengajukan form ini, mohon serahkan perangkat fisik ke gerai bengkel terdekat.</p>
                <p>2. Estimasi biaya awal dan diagnosa detail akan diperbarui oleh Admin setelah perangkat diperiksa secara fisik oleh Teknisi.</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('pelanggan.servis.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">Batal</a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-600/10">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection
