@extends('layouts.admin')

@section('header_title', 'Manajemen Servis')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-950">Daftar Antrean Servis</h2>
            <p class="text-sm text-slate-500">Kelola antrean perbaikan perangkat pelanggan di sini.</p>
        </div>
        <a href="{{ route('admin.servis.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Servis Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.servis.index') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 w-full flex flex-col sm:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Perangkat atau Pelanggan..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <select name="status" onchange="this.form.submit()" 
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                        <option value="">Semua Status</option>
                        <option value="antri" {{ request('status') === 'antri' ? 'selected' : '' }}>Antri</option>
                        <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="diambil" {{ request('status') === 'diambil' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button & Reset -->
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-all">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.servis.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                    @forelse($servis as $item)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-slate-900">{{ $item->kode_servis }}</td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-950">{{ $item->pelanggan->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $item->pelanggan->no_hp }}</div>
                            </td>
                            <td class="p-4 text-slate-700">{{ $item->nama_perangkat }}</td>
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
                                <button type="button" onclick="openDeleteModal('{{ route('admin.servis.destroy', $item->id) }}', '{{ $item->kode_servis }}')" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition-colors">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Tidak ada data servis yang sesuai pencarian atau filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        @if($servis->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $servis->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-all duration-300">
        <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
        <p class="text-slate-500 mt-2 text-sm">Apakah Anda yakin ingin menghapus data servis <span id="deleteItemCode" class="font-semibold text-slate-800"></span>? Data ini akan dipindahkan ke tempat sampah (Soft Delete).</p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-lg shadow-red-600/10">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, itemCode) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteItemCode').textContent = itemCode;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
