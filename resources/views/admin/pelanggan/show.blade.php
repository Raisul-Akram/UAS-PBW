@extends('layouts.admin')

@section('header_title', 'Detail Pelanggan ' . $pelanggan->user->name)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.pelanggan.index') }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Profil Pelanggan</h2>
            <p class="text-sm text-slate-500">Informasi detail akun dan histori perbaikan yang pernah diajukan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bio Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit space-y-4">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-extrabold text-lg">
                    {{ strtoupper(substr($pelanggan->user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-bold text-lg text-slate-900">{{ $pelanggan->user->name }}</h3>
                    <span class="text-xs text-slate-500">Terdaftar {{ $pelanggan->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="space-y-3.5">
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Alamat Email</p>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pelanggan->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">No. WhatsApp / HP</p>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pelanggan->no_hp }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Alamat Rumah</p>
                    <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line leading-relaxed">{{ $pelanggan->alamat }}</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl text-sm transition-all shadow-md shadow-amber-500/10">
                    Edit Data Pelanggan
                </a>
            </div>
        </div>

        <!-- History Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h3 class="text-base font-bold text-slate-800">Riwayat Pengajuan Servis (Total: {{ $pelanggan->servis->count() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="p-4 pl-6">Kode</th>
                            <th class="p-4">Perangkat</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Tgl Masuk</th>
                            <th class="p-4 pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pelanggan->servis as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 pl-6 font-semibold text-slate-900">{{ $item->kode_servis }}</td>
                                <td class="p-4 text-slate-700 font-medium">{{ $item->nama_perangkat }}</td>
                                <td class="p-4">
                                    @if($item->status === 'antri')
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md uppercase">Antri</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-md uppercase">Diproses</span>
                                    @elseif($item->status === 'selesai')
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-md uppercase">Selesai</span>
                                    @elseif($item->status === 'diambil')
                                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-md uppercase">Diambil</span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-500 text-sm">{{ $item->tgl_masuk->format('d M Y') }}</td>
                                <td class="p-4 pr-6 text-right">
                                    <a href="{{ route('admin.servis.show', $item->id) }}" class="inline-flex items-center px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-md text-xs font-semibold transition-colors">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400">Pelanggan ini belum pernah melakukan pengajuan servis perbaikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
