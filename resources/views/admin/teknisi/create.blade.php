@extends('layouts.admin')

@section('header_title', 'Tambah Teknisi')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.teknisi.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Tambah Teknisi Baru</h2>
            <p class="text-sm text-slate-500">Daftarkan personel teknisi baru beserta keahlian spesifikasinya.</p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form method="POST" action="{{ route('admin.teknisi.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Teknisi -->
            <div class="space-y-1.5">
                <label for="nama" class="text-sm font-semibold text-slate-700">Nama Teknisi <span class="text-rose-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Ahmad Hidayat"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('nama') border-rose-500 @enderror">
                @error('nama')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="space-y-1.5">
                <label for="no_hp" class="text-sm font-semibold text-slate-700">Nomor HP <span class="text-rose-500">*</span></label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('no_hp') border-rose-500 @enderror">
                <p class="text-xs text-slate-400 mt-0.5">Harus berformat nomor HP Indonesia diawali 08 (10-13 digit).</p>
                @error('no_hp')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Spesialisasi -->
            <div class="space-y-1.5">
                <label for="spesialisasi" class="text-sm font-semibold text-slate-700">Spesialisasi Keahlian <span class="text-rose-500">*</span></label>
                <input type="text" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}" placeholder="Contoh: Hardware Laptop / Layar / HP Android"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('spesialisasi') border-rose-500 @enderror">
                @error('spesialisasi')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="status_aktif" name="status_aktif" value="1" checked
                       class="w-4.5 h-4.5 text-amber-500 bg-slate-100 border-slate-300 rounded focus:ring-amber-500/20">
                <label for="status_aktif" class="text-sm font-semibold text-slate-700 select-none">Teknisi langsung aktif untuk menerima tugas</label>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.teknisi.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">Batal</a>
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">Simpan Teknisi</button>
            </div>
        </form>
    </div>
</div>
@endsection
