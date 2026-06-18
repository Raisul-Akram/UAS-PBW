@extends('layouts.pelanggan')

@section('header_title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-indigo-600 to-violet-700 text-white p-6 md:p-8 rounded-2xl shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2">
            <h2 class="text-2xl md:text-3xl font-extrabold">Halo, {{ auth()->user()->name }}!</h2>
            <p class="text-indigo-100 text-sm md:text-base">Selamat datang di Portal Pelayanan Bengkel Servis kami. Di sini Anda bisa memantau status perbaikan perangkat Anda secara real-time.</p>
        </div>
        <a href="{{ route('pelanggan.servis.create') }}" class="shrink-0 px-6 py-3.5 bg-white hover:bg-indigo-50 text-indigo-700 font-bold rounded-xl transition-all shadow-lg shadow-black/10">
            Ajukan Servis Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Servis -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Pengajuan</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['total_servis'] }}</h3>
            </div>
            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>

        <!-- Servis Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Servis Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['servis_aktif'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">Dalam antrean atau proses pengerjaan</p>
            </div>
            <div class="p-3.5 bg-blue-50 text-blue-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Servis Selesai -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Selesai Perbaikan</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['servis_selesai'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">Siap diambil atau sudah diserahterimakan</p>
            </div>
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Services -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Servis Saya Terbaru</h2>
            <a href="{{ route('pelanggan.servis.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 pl-6">Kode Servis</th>
                        <th class="p-4">Perangkat</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Biaya</th>
                        <th class="p-4">Tgl Masuk</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentServices as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-slate-900">{{ $item->kode_servis }}</td>
                            <td class="p-4 font-medium text-slate-850">{{ $item->nama_perangkat }}</td>
                            <td class="p-4">
                                @if($item->status === 'antri')
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full uppercase tracking-wider">Antri</span>
                                @elseif($item->status === 'diproses')
                                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full uppercase tracking-wider">Diproses</span>
                                @elseif($item->status === 'selesai')
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full uppercase tracking-wider">Selesai</span>
                                @elseif($item->status === 'diambil')
                                    <span class="px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full uppercase tracking-wider">Diambil</span>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-slate-955">
                                @if($item->biaya_final)
                                    <span class="text-emerald-600 font-bold">Rp {{ number_format($item->biaya_final, 0, ',', '.') }}</span>
                                    <div class="text-xxs text-slate-400 font-normal">Final</div>
                                @elseif($item->estimasi_biaya == 0)
                                    <span class="text-slate-400 text-xs italic">Menunggu diagnosa</span>
                                @else
                                    Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}
                                    <div class="text-xxs text-slate-400 font-normal">Estimasi</div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500 text-sm">{{ $item->tgl_masuk->format('d M Y') }}</td>
                            <td class="p-4 pr-6 text-right">
                                <a href="{{ route('pelanggan.servis.show', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-xs font-bold transition-colors">
                                    Lacak Progres
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Anda belum mengajukan perbaikan servis perangkat saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
