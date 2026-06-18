@extends('layouts.pelanggan')

@section('header_title', 'Servis Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-955">Daftar Perbaikan Perangkat</h2>
            <p class="text-sm text-slate-500">Histori pengajuan perbaikan dan status pengerjaan perangkat Anda.</p>
        </div>
        <a href="{{ route('pelanggan.servis.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-600/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Ajukan Servis Baru</span>
        </a>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                    @forelse($servis as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-slate-900">{{ $item->kode_servis }}</td>
                            <td class="p-4 font-semibold text-slate-800">{{ $item->nama_perangkat }}</td>
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
                             <td class="p-4 font-semibold text-slate-950">
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
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data pengajuan perbaikan. Silakan buat pengajuan pertama Anda!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($servis->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $servis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
