@extends('layouts.admin')

@section('header_title', 'Detail Servis ' . $servis->kode_servis)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.servis.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Detail Pelacakan Servis</h2>
            <p class="text-sm text-slate-500">Rincian data perangkat, penugasan teknisi, dan histori perubahan status.</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Side: Detail Cards -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Perangkat -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800">Informasi Perangkat & Kerusakan</h3>
                    @if($servis->status === 'antri')
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full uppercase tracking-wider">Antri</span>
                    @elseif($servis->status === 'diproses')
                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full uppercase tracking-wider">Diproses</span>
                    @elseif($servis->status === 'selesai')
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full uppercase tracking-wider">Selesai</span>
                    @elseif($servis->status === 'diambil')
                        <span class="px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full uppercase tracking-wider">Diambil</span>
                    @endif
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Nama Perangkat</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $servis->nama_perangkat }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Kode Registrasi</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $servis->kode_servis }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Gejala / Jenis Kerusakan</p>
                        <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line">{{ $servis->jenis_kerusakan }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Tanggal Masuk</p>
                            <p class="text-sm text-slate-800 mt-0.5">{{ $servis->tgl_masuk->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Target Estimasi Selesai</p>
                            <p class="text-sm text-slate-800 mt-0.5">{{ $servis->tgl_estimasi_selesai->format('d M Y') }}</p>
                        </div>
                    </div>
                    @if($servis->tgl_selesai)
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Tanggal Rampung</p>
                            <p class="text-sm font-semibold text-emerald-700 mt-0.5">{{ $servis->tgl_selesai->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Biaya & Catatan Teknisi -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-base font-bold text-slate-800">Biaya & Tindakan Perbaikan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Estimasi Biaya Awal</p>
                            <p class="text-lg font-bold text-slate-800 mt-1">
                                @if($servis->estimasi_biaya == 0)
                                    <span class="text-slate-400 font-semibold italic text-sm">Menunggu diagnosa</span>
                                @else
                                    Rp {{ number_format($servis->estimasi_biaya, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                            <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Biaya Akhir (Final)</p>
                            <p class="text-lg font-bold text-emerald-800 mt-1">
                                {{ $servis->biaya_final ? 'Rp ' . number_format($servis->biaya_final, 0, ',', '.') : 'Belum ditentukan' }}
                            </p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Catatan Teknisi / Hasil Diagnosis</p>
                        <div class="mt-1 p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 whitespace-pre-line min-h-[80px]">
                            {{ $servis->catatan_teknisi ?? 'Belum ada catatan teknis dari pengerjaan ini.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Sidebar Detail (Pelanggan & Teknisi & Timeline) -->
        <div class="space-y-6">
            <!-- Card Pelanggan & Teknisi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3">Pihak Terkait</h3>
                
                <!-- Pelanggan -->
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Pelanggan</p>
                    <a href="{{ route('admin.pelanggan.show', $servis->pelanggan_id) }}" class="block font-semibold text-slate-800 hover:text-amber-600 transition-colors">
                        {{ $servis->pelanggan->user->name }}
                    </a>
                    <p class="text-xs text-slate-500">{{ $servis->pelanggan->no_hp }}</p>
                </div>
                
                <!-- Teknisi -->
                <div class="space-y-1 pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Teknisi Penanggungjawab</p>
                    @if($servis->teknisi)
                        <a href="{{ route('admin.teknisi.show', $servis->teknisi_id) }}" class="block font-semibold text-slate-800 hover:text-amber-600 transition-colors">
                            {{ $servis->teknisi->nama }}
                        </a>
                        <p class="text-xs text-slate-500">Spesialisasi: {{ $servis->teknisi->spesialisasi }}</p>
                    @else
                        <p class="text-sm font-semibold text-rose-500">Belum ada teknisi ditunjuk</p>
                    @endif
                </div>

                <div class="pt-4">
                    <a href="{{ route('admin.servis.edit', $servis->id) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl text-sm transition-all shadow-md shadow-amber-500/10">
                        Edit Servis
                    </a>
                </div>
            </div>

            <!-- Card Timeline Histori Status -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3">Histori Pelacakan</h3>
                
                <!-- Timeline Vertikal -->
                <div class="flow-root">
                    <ul class="-mb-8">
                        @forelse($servis->riwayatStatus as $index => $history)
                            <li>
                                <div class="relative pb-8">
                                    @if($index !== count($servis->riwayatStatus) - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            @if($history->status_baru === 'antri')
                                                <span class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center ring-8 ring-white text-slate-500">
                                                    <span class="text-xs font-bold uppercase">AN</span>
                                                </span>
                                            @elseif($history->status_baru === 'diproses')
                                                <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center ring-8 ring-white text-blue-600">
                                                    <span class="text-xs font-bold uppercase">PR</span>
                                                </span>
                                            @elseif($history->status_baru === 'selesai')
                                                <span class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center ring-8 ring-white text-emerald-600">
                                                    <span class="text-xs font-bold uppercase">SL</span>
                                                </span>
                                            @elseif($history->status_baru === 'diambil')
                                                <span class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white text-purple-600">
                                                    <span class="text-xs font-bold uppercase">AM</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1.5">
                                            <p class="text-sm font-semibold text-slate-800">
                                                Status: <span class="uppercase text-xs px-2 py-0.5 bg-slate-100 rounded-md">{{ $history->status_baru }}</span>
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $history->catatan ?? 'Tidak ada catatan.' }}</p>
                                            <div class="mt-2 flex items-center justify-between text-xxs text-slate-400">
                                                <span>Oleh: {{ $history->changedBy->name }}</span>
                                                <span>{{ $history->created_at->format('d M H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-sm text-slate-400 text-center">Belum ada riwayat status.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
