<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServisRequest;
use App\Models\Servis;
use App\Models\Pelanggan;
use App\Models\Teknisi;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServisController extends Controller
{
    /**
     * Tampilkan daftar servis dengan pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Servis::with(['pelanggan.user', 'teknisi']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian berdasarkan kode_servis atau nama perangkat atau nama pelanggan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_servis', 'like', "%{$search}%")
                  ->orWhere('nama_perangkat', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan.user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $servis = $query->latest('tgl_masuk')->paginate(10)->withQueryString();

        return view('admin.servis.index', compact('servis'));
    }

    /**
     * Tampilkan form pembuatan servis baru.
     */
    public function create()
    {
        $pelanggan = Pelanggan::with('user')->get();
        $teknisi = Teknisi::where('status_aktif', true)->get();

        return view('admin.servis.create', compact('pelanggan', 'teknisi'));
    }

    /**
     * Simpan data servis baru.
     */
    public function store(ServisRequest $request)
    {
        DB::beginTransaction();
        try {
            // Validasi data tambahan yang tidak dicakup oleh ServisRequest
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'teknisi_id' => 'nullable|exists:teknisis,id',
            ], [
                'pelanggan_id.required' => 'Pelanggan harus dipilih.',
                'pelanggan_id.exists' => 'Pelanggan tidak valid.',
                'teknisi_id.exists' => 'Teknisi tidak valid.',
            ]);

            // Buat servis
            $servis = Servis::create([
                'pelanggan_id' => $request->pelanggan_id,
                'teknisi_id' => $request->teknisi_id,
                'nama_perangkat' => $request->nama_perangkat,
                'jenis_kerusakan' => $request->jenis_kerusakan,
                'estimasi_biaya' => $request->estimasi_biaya,
                'tgl_estimasi_selesai' => $request->tgl_estimasi_selesai,
                'status' => 'antri', // Status awal default
                'tgl_masuk' => now(),
            ]);

            // Catat riwayat status awal
            RiwayatStatus::create([
                'servis_id' => $servis->id,
                'status_lama' => null,
                'status_baru' => 'antri',
                'catatan' => 'Servis didaftarkan oleh Administrator.',
                'changed_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.servis.index')
                ->with('success', 'Data servis berhasil dibuat dengan kode: ' . $servis->kode_servis);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail servis beserta timeline.
     */
    public function show(Servis $servis)
    {
        $servis->load(['pelanggan.user', 'teknisi', 'riwayatStatus.changedBy']);
        
        return view('admin.servis.show', compact('servis'));
    }

    /**
     * Tampilkan form edit servis.
     */
    public function edit(Servis $servis)
    {
        $teknisi = Teknisi::where('status_aktif', true)->get();
        return view('admin.servis.edit', compact('servis', 'teknisi'));
    }

    /**
     * Update data servis.
     */
    public function update(Request $request, Servis $servis)
    {
        // Bersihkan format titik/koma ribuan dari input estimasi_biaya jika ada
        if ($request->filled('estimasi_biaya')) {
            $request->merge([
                'estimasi_biaya' => preg_replace('/[^0-9]/', '', $request->estimasi_biaya),
            ]);
        }

        // Bersihkan format titik/koma ribuan dari input biaya_final jika ada
        if ($request->filled('biaya_final')) {
            $request->merge([
                'biaya_final' => preg_replace('/[^0-9]/', '', $request->biaya_final),
            ]);
        }

        // Validasi data edit servis
        $request->validate([
            'status' => 'required|in:antri,diproses,selesai,diambil',
            'teknisi_id' => 'nullable|exists:teknisis,id',
            'estimasi_biaya' => 'required|numeric|min:0',
            'biaya_final' => 'nullable|numeric|min:0',
            'catatan_teknisi' => 'nullable|string',
        ], [
            'status.required' => 'Status servis wajib diisi.',
            'status.in' => 'Status servis tidak valid.',
            'teknisi_id.exists' => 'Teknisi tidak valid.',
            'estimasi_biaya.required' => 'Estimasi biaya wajib diisi.',
            'estimasi_biaya.numeric' => 'Estimasi biaya harus berupa angka.',
            'estimasi_biaya.min' => 'Estimasi biaya tidak boleh kurang dari 0.',
            'biaya_final.numeric' => 'Biaya final harus berupa angka.',
            'biaya_final.min' => 'Biaya final tidak boleh kurang dari 0.',
        ]);

        DB::beginTransaction();
        try {
            $statusLama = $servis->status;
            $statusBaru = $request->status;

            // Jika status berubah, catat riwayat status
            if ($statusLama !== $statusBaru) {
                RiwayatStatus::create([
                    'servis_id' => $servis->id,
                    'status_lama' => $statusLama,
                    'status_baru' => $statusBaru,
                    'catatan' => $request->catatan_riwayat ?? 'Perubahan status oleh Administrator.',
                    'changed_by' => auth()->id(),
                ]);

                // Jika status baru adalah selesai atau diambil, set tgl_selesai
                if (in_array($statusBaru, ['selesai', 'diambil']) && is_null($servis->tgl_selesai)) {
                    $servis->tgl_selesai = now();
                } elseif (!in_array($statusBaru, ['selesai', 'diambil'])) {
                    $servis->tgl_selesai = null; // Reset jika diturunkan statusnya
                }
            }

            // Update attributes
            $servis->status = $statusBaru;
            $servis->teknisi_id = $request->teknisi_id;
            $servis->estimasi_biaya = $request->estimasi_biaya;
            $servis->biaya_final = $request->biaya_final;
            $servis->catatan_teknisi = $request->catatan_teknisi;
            $servis->save();

            DB::commit();

            return redirect()->route('admin.servis.index')
                ->with('success', 'Data servis ' . $servis->kode_servis . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data servis (soft delete).
     */
    public function destroy(Servis $servis)
    {
        $servis->delete();

        return redirect()->route('admin.servis.index')
            ->with('success', 'Data servis ' . $servis->kode_servis . ' berhasil dihapus (Soft Delete).');
    }
}
