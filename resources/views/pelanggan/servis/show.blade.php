@extends('layouts.pelanggan')

@section('header_title', 'Lacak Servis ' . $servis->kode_servis)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('pelanggan.servis.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-955">Lacak Perjalanan Servis</h2>
            <p class="text-sm text-slate-500">Pelacakan real-time progress perbaikan dan diagnosa perangkat Anda.</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Perangkat -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800">Detail Perangkat & Diagnosa</h3>
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
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Kode Lacak (Servis ID)</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $servis->kode_servis }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Deskripsi Kerusakan</p>
                        <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line">{{ $servis->jenis_kerusakan }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Tanggal Pengajuan</p>
                            <p class="text-sm text-slate-800 mt-0.5">{{ $servis->tgl_masuk->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Estimasi Tanggal Selesai</p>
                            <p class="text-sm text-slate-800 mt-0.5">{{ $servis->tgl_estimasi_selesai->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Biaya & Catatan Teknisi -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-base font-bold text-slate-800">Biaya Layanan & Catatan Bengkel</h3>
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
                            <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Biaya Final Akhir</p>
                            <p class="text-lg font-bold text-emerald-800 mt-1">
                                @if($servis->biaya_final)
                                    Rp {{ number_format($servis->biaya_final, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-400 font-semibold italic text-sm">Menunggu selesai</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Catatan Teknisi / Hasil Diagnosis</p>
                        <div class="mt-1 p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 whitespace-pre-line min-h-[80px]">
                            {{ $servis->catatan_teknisi ?? 'Perangkat sedang dalam diagnosa teknisi. Catatan perbaikan akan tampil di sini setelah dikerjakan.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline & Teknisi -->
        <div class="space-y-6">
            <!-- Card Teknisi PJ -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3.5">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3">Teknisi Penanggungjawab</h3>
                @if($servis->teknisi)
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            {{ strtoupper(substr($servis->teknisi->nama, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">{{ $servis->teknisi->nama }}</p>
                            <p class="text-xs text-slate-500">Spesialisasi: {{ $servis->teknisi->spesialisasi }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-xs font-semibold">Perangkat Anda sedang mengantri untuk ditunjuk teknisi penanggungjawab.</p>
                    </div>
                @endif
            </div>

            <!-- Card Timeline Tracking -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3">Timeline Perubahan Status</h3>
                
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
                                            <p class="text-sm font-semibold text-slate-850">
                                                Status: <span class="uppercase text-xs px-2 py-0.5 bg-slate-100 rounded-md font-bold text-slate-600">{{ $history->status_baru }}</span>
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $history->catatan ?? 'Tidak ada catatan.' }}</p>
                                            <div class="mt-2 flex items-center justify-between text-xxs text-slate-400">
                                                <span>Diperbarui pada:</span>
                                                <span>{{ $history->created_at->format('d M H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-sm text-slate-400 text-center">Belum ada riwayat status pelacakan.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
