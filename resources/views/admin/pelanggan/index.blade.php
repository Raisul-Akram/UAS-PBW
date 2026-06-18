@extends('layouts.admin')

@section('header_title', 'Data Pelanggan')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-955">Daftar Pelanggan Terdaftar</h2>
        <p class="text-sm text-slate-500">Kelola akun profil pelanggan, informasi kontak, dan alamat.</p>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 pl-6">Nama Pelanggan</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">No. HP</th>
                        <th class="p-4">Alamat</th>
                        <th class="p-4">Terdaftar Sejak</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pelanggans as $p)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-slate-950">
                                <a href="{{ route('admin.pelanggan.show', $p->id) }}" class="hover:text-amber-600 transition-colors">
                                    {{ $p->user->name }}
                                </a>
                            </td>
                            <td class="p-4 text-slate-600">{{ $p->user->email }}</td>
                            <td class="p-4 text-slate-700 font-semibold">{{ $p->no_hp }}</td>
                            <td class="p-4 text-slate-500 text-sm max-w-xs truncate">{{ $p->alamat }}</td>
                            <td class="p-4 text-slate-500 text-sm">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="p-4 pr-6 text-right space-x-2">
                                <a href="{{ route('admin.pelanggan.show', $p->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition-colors">Detail</a>
                                <a href="{{ route('admin.pelanggan.edit', $p->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-semibold transition-colors">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada pelanggan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggans->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $pelanggans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
