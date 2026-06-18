@extends('layouts.admin')

@section('header_title', 'Edit Servis ' . $servis->kode_servis)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.servis.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Update Status & Detail Servis</h2>
            <p class="text-sm text-slate-500">Perbarui status pengerjaan perangkat, biaya final, dan catatan teknisi.</p>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-slate-100 p-5 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between gap-4">
        <div>
            <p class="text-xs uppercase text-slate-500 font-bold tracking-wider">Perangkat & Pelanggan</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $servis->nama_perangkat }}</h3>
            <p class="text-sm text-slate-600">Pelanggan: <span class="font-semibold">{{ $servis->pelanggan->user->name }}</span> ({{ $servis->pelanggan->no_hp }})</p>
        </div>
        <div class="sm:text-right">
            <p class="text-xs uppercase text-slate-500 font-bold tracking-wider">Estimasi Awal</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">Rp {{ number_format($servis->estimasi_biaya, 0, ',', '.') }}</h3>
            <p class="text-sm text-slate-500">Target selesai: {{ $servis->tgl_estimasi_selesai->format('d M Y') }}</p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form method="POST" action="{{ route('admin.servis.update', $servis->id) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Servis -->
                <div class="space-y-1.5">
                    <label for="status" class="text-sm font-semibold text-slate-700">Status Servis <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('status') border-rose-500 @enderror">
                        <option value="antri" {{ old('status', $servis->status) === 'antri' ? 'selected' : '' }}>Antri</option>
                        <option value="diproses" {{ old('status', $servis->status) === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ old('status', $servis->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="diambil" {{ old('status', $servis->status) === 'diambil' ? 'selected' : '' }}>Diambil</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teknisi Dropdown -->
                <div class="space-y-1.5">
                    <label for="teknisi_id" class="text-sm font-semibold text-slate-700">Penugasan Teknisi</label>
                    <select id="teknisi_id" name="teknisi_id" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('teknisi_id') border-rose-500 @enderror">
                        <option value="">-- Belum Ditugaskan --</option>
                        @foreach($teknisi as $t)
                            <option value="{{ $t->id }}" {{ old('teknisi_id', $servis->teknisi_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->nama }} (Spesialisasi: {{ $t->spesialisasi }})
                            </option>
                        @endforeach
                    </select>
                    @error('teknisi_id')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Estimasi Biaya -->
                <div class="space-y-1.5">
                    <label for="estimasi_biaya" class="text-sm font-semibold text-slate-700">Estimasi Biaya (Rp) <span class="text-rose-500">*</span></label>
                    <input type="text" id="estimasi_biaya" name="estimasi_biaya" value="{{ old('estimasi_biaya', !is_null($servis->estimasi_biaya) ? number_format($servis->estimasi_biaya, 0, ',', '.') : '') }}" placeholder="Contoh: 1.500.000"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('estimasi_biaya') border-rose-500 @enderror">
                    <p class="text-xs text-slate-400 mt-1">Estimasi biaya awal perbaikan.</p>
                    @error('estimasi_biaya')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Final -->
                <div class="space-y-1.5">
                    <label for="biaya_final" class="text-sm font-semibold text-slate-700">Biaya Final (Rp)</label>
                    <input type="text" id="biaya_final" name="biaya_final" value="{{ old('biaya_final', !is_null($servis->biaya_final) ? number_format($servis->biaya_final, 0, ',', '.') : '') }}" placeholder="Contoh: 1.500.000"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('biaya_final') border-rose-500 @enderror">
                    <p class="text-xs text-slate-400 mt-1">Kosongkan jika masih proses pemeriksaan/antrean.</p>
                    @error('biaya_final')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan Riwayat (Log Status) -->
            <div class="space-y-1.5">
                <label for="catatan_riwayat" class="text-sm font-semibold text-slate-700">Catatan Perubahan Status (Opsional)</label>
                <input type="text" id="catatan_riwayat" name="catatan_riwayat" placeholder="Contoh: Menunggu sparepart / Sedang dibongkar"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                <p class="text-xs text-slate-400 mt-1">Catatan ini akan tampil di timeline pelacakan milik pelanggan.</p>
            </div>

            <!-- Catatan Teknisi -->
            <div class="space-y-1.5">
                <label for="catatan_teknisi" class="text-sm font-semibold text-slate-700">Catatan Teknisi / Hasil Diagnosis</label>
                <textarea id="catatan_teknisi" name="catatan_teknisi" rows="4" placeholder="Tulis rincian perbaikan yang dilakukan teknisi atau sparepart yang diganti..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none @error('catatan_teknisi') border-rose-500 @enderror">{{ old('catatan_teknisi', $servis->catatan_teknisi) }}</textarea>
                @error('catatan_teknisi')
                    <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.servis.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">Batal</a>
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">Simpan Perubahan</button>
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
        const biayaFinalInput = document.getElementById('biaya_final');

        if (estimasiInput) {
            estimasiInput.addEventListener('input', function() {
                formatInput(this);
            });
            formatInput(estimasiInput);
        }

        if (biayaFinalInput) {
            biayaFinalInput.addEventListener('input', function() {
                formatInput(this);
            });
            formatInput(biayaFinalInput);
        }
    });
</script>
@endsection
