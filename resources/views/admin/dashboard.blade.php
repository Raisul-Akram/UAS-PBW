@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Servis -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Servis</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['total_servis'] }}</h3>
            </div>
            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>
        
        <!-- Servis Aktif (Antri + Diproses) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Aktif (Antri/Proses)</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['servis_antri'] + $stats['servis_proses'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['servis_antri'] }} antri, {{ $stats['servis_proses'] }} diproses</p>
            </div>
            <div class="p-3.5 bg-sky-50 text-sky-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Servis Selesai (Selesai + Diambil) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Selesai (Selesai/Diambil)</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['servis_selesai'] + $stats['servis_diambil'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['servis_selesai'] }} selesai, {{ $stats['servis_diambil'] }} diambil</p>
            </div>
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Pelanggan & Teknisi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Pelanggan & Teknisi</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $stats['total_pelanggan'] }} / {{ $stats['total_teknisi'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">Pelanggan terdaftar / Teknisi aktif</p>
            </div>
            <div class="p-3.5 bg-amber-50 text-amber-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Services -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Antrean Servis Terbaru</h2>
            <a href="{{ route('admin.servis.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 pl-6">Kode</th>
                        <th class="p-4">Pelanggan</th>
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
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $item->pelanggan->user->name }}</div>
                            </td>
                            <td class="p-4 text-slate-600">{{ $item->nama_perangkat }}</td>
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
                            <td class="p-4 font-semibold text-slate-900">
                                @if($item->biaya_final)
                                    <span class="text-emerald-700">Rp {{ number_format($item->biaya_final, 0, ',', '.') }}</span>
                                    <div class="text-xxs text-slate-400 font-normal">Final</div>
                                @else
                                    Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}
                                    <div class="text-xxs text-slate-400 font-normal">Estimasi</div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500 text-sm">{{ $item->tgl_masuk->format('d M Y H:i') }}</td>
                            <td class="p-4 pr-6 text-right space-x-2">
                                <a href="{{ route('admin.servis.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition-colors">Detail</a>
                                <a href="{{ route('admin.servis.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-semibold transition-colors">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada antrean servis saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
