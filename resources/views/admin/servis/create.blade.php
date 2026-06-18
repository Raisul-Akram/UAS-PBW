@extends('layouts.admin')

@section('header_title', 'Tambah Servis Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.servis.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-955">Tambah Antrean Servis</h2>
            <p class="text-sm text-slate-500">Buat data pendaftaran servis baru untuk pelanggan.</p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form method="POST" action="{{ route('admin.servis.store') }}" class="space-y-6">
            @csrf

            <!-- Pelanggan Dropdown -->
            <div class="space-y-1.5">
                <label for="pelanggan_id" class="text-sm font-semibold text-slate-700">Pilih Pelanggan <span class="text-rose-500">*</span></label>
                <select id="pelanggan_id" name="pelanggan_id" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('pelanggan_id') border-rose-500 @enderror">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->user->name }} ({{ $p->no_hp }} - {{ Str::limit($p->alamat, 40) }})
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Perangkat -->
                <div class="space-y-1.5">
                    <label for="nama_perangkat" class="text-sm font-semibold text-slate-700">Nama Perangkat <span class="text-rose-500">*</span></label>
                    <input type="text" id="nama_perangkat" name="nama_perangkat" value="{{ old('nama_perangkat') }}" placeholder="Contoh: Laptop Asus ROG G531"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('nama_perangkat') border-rose-500 @enderror">
                    @error('nama_perangkat')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimasi Biaya -->
                <div class="space-y-1.5">
                    <label for="estimasi_biaya" class="text-sm font-semibold text-slate-700">Estimasi Biaya (Rp) <span class="text-rose-500">*</span></label>
                    <input type="text" id="estimasi_biaya" name="estimasi_biaya" value="{{ old('estimasi_biaya') }}" placeholder="Contoh: 1.500.000"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('estimasi_biaya') border-rose-500 @enderror">
                    @error('estimasi_biaya')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Jenis Kerusakan -->
            <div class="space-y-1.5">
                <label for="jenis_kerusakan" class="text-sm font-semibold text-slate-700">Jenis/Deskripsi Kerusakan <span class="text-rose-500">*</span></label>
                <textarea id="jenis_kerusakan" name="jenis_kerusakan" rows="3" placeholder="Jelaskan secara detail gejala atau kerusakan perangkat..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('jenis_kerusakan') border-rose-500 @enderror">{{ old('jenis_kerusakan') }}</textarea>
                @error('jenis_kerusakan')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Estimasi Selesai -->
                <div class="space-y-1.5">
                    <label for="tgl_estimasi_selesai" class="text-sm font-semibold text-slate-700">Estimasi Selesai <span class="text-rose-500">*</span></label>
                    <input type="date" id="tgl_estimasi_selesai" name="tgl_estimasi_selesai" value="{{ old('tgl_estimasi_selesai') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('tgl_estimasi_selesai') border-rose-500 @enderror">
                    @error('tgl_estimasi_selesai')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teknisi Dropdown -->
                <div class="space-y-1.5">
                    <label for="teknisi_id" class="text-sm font-semibold text-slate-700">Tugaskan Teknisi (Opsional)</label>
                    <select id="teknisi_id" name="teknisi_id" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('teknisi_id') border-rose-500 @enderror">
                        <option value="">-- Belum Ditugaskan --</option>
                        @foreach($teknisi as $t)
                            <option value="{{ $t->id }}" {{ old('teknisi_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->nama }} (Spesialisasi: {{ $t->spesialisasi }})
                            </option>
                        @endforeach
                    </select>
                    @error('teknisi_id')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.servis.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">Batal</a>
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">Simpan Servis</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formatInput = (input) => {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        };

        const estimasiInput = document.getElementById('estimasi_biaya');

        if (estimasiInput) {
            estimasiInput.addEventListener('input', function() {
                formatInput(this);
            });
            formatInput(estimasiInput);
        }
    });
</script>
@endsection
