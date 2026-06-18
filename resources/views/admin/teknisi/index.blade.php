@extends('layouts.admin')

@section('header_title', 'Data Teknisi')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-955">Daftar Teknisi Bengkel</h2>
            <p class="text-sm text-slate-500">Kelola informasi data teknisi, keahlian spesialisasi, dan status aktif.</p>
        </div>
        <a href="{{ route('admin.teknisi.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-amber-500 hover:bg-amber-600 text-slate-955 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Teknisi</span>
        </a>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 pl-6">Nama Teknisi</th>
                        <th class="p-4">No. HP</th>
                        <th class="p-4">Spesialisasi</th>
                        <th class="p-4">Status Aktif</th>
                        <th class="p-4">Terdaftar Sejak</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($teknisis as $t)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-slate-950">
                                <a href="{{ route('admin.teknisi.show', $t->id) }}" class="hover:text-amber-600 transition-colors">
                                    {{ $t->nama }}
                                </a>
                            </td>
                            <td class="p-4 text-slate-600">{{ $t->no_hp }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-800 text-xs font-medium rounded-lg">{{ $t->spesialisasi }}</span>
                            </td>
                            <td class="p-4">
                                @if($t->status_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-500 text-xs font-semibold rounded-full uppercase tracking-wider">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500 text-sm">{{ $t->created_at->format('d M Y') }}</td>
                            <td class="p-4 pr-6 text-right space-x-2">
                                <a href="{{ route('admin.teknisi.show', $t->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition-colors">Detail</a>
                                <a href="{{ route('admin.teknisi.edit', $t->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-semibold transition-colors">Edit</a>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.teknisi.destroy', $t->id) }}', '{{ $t->nama }}')" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition-colors">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data teknisi terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teknisis->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $teknisis->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-all duration-300">
        <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
        <p class="text-slate-500 mt-2 text-sm">Apakah Anda yakin ingin menghapus data teknisi <span id="deleteItemName" class="font-semibold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.</p>
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
    function openDeleteModal(actionUrl, itemName) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteItemName').textContent = itemName;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
