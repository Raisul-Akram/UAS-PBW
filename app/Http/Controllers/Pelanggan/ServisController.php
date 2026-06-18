<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServisRequest;
use App\Models\Servis;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServisController extends Controller
{
    /**
     * Tampilkan semua servis milik pelanggan log-in.
     */
    public function index()
    {
        $pelanggan = auth()->user()->pelanggan;

        if (!$pelanggan) {
            abort(403, 'Data profil pelanggan tidak ditemukan.');
        }

        $servis = $pelanggan->servis()->with('teknisi')->latest('tgl_masuk')->paginate(10);

        return view('pelanggan.servis.index', compact('servis'));
    }

    /**
     * Tampilkan form pengajuan servis baru.
     */
    public function create()
    {
        return view('pelanggan.servis.create');
    }

    /**
     * Simpan pengajuan servis baru.
     */
    public function store(ServisRequest $request)
    {
        $pelanggan = auth()->user()->pelanggan;

        if (!$pelanggan) {
            abort(403, 'Anda tidak memiliki hak akses sebagai pelanggan.');
        }

        DB::beginTransaction();
        try {
            // Buat servis baru dengan status awal 'antri'
            $servis = Servis::create([
                'pelanggan_id' => $pelanggan->id,
                'teknisi_id' => null, // Belum ditugaskan teknisi
                'nama_perangkat' => $request->nama_perangkat,
                'jenis_kerusakan' => $request->jenis_kerusakan,
                'status' => 'antri',
                'estimasi_biaya' => 0, // Awal pengajuan biaya 0 sebelum diperiksa admin
                'tgl_estimasi_selesai' => now()->addDays(3), // Placeholder estimasi awal
                'tgl_masuk' => now(),
            ]);

            // Catat ke riwayat status
            RiwayatStatus::create([
                'servis_id' => $servis->id,
                'status_lama' => null,
                'status_baru' => 'antri',
                'catatan' => 'Pengajuan servis baru diajukan oleh Pelanggan.',
                'changed_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('pelanggan.servis.index')
                ->with('success', 'Pengajuan servis baru berhasil dibuat dengan kode: ' . $servis->kode_servis);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail tracking servis.
     */
    public function show(Servis $servis)
    {
        $pelanggan = auth()->user()->pelanggan;

        // PROTEKSI KEAMANAN (Mencegah IDOR / Mengakses data orang lain)
        if (!$pelanggan || $servis->pelanggan_id !== $pelanggan->id) {
            abort(403, 'Akses ditolak. Anda tidak berwenang melihat data servis ini.');
        }

        $servis->load(['teknisi', 'riwayatStatus' => function ($q) {
            $q->with('changedBy')->latest();
        }]);

        return view('pelanggan.servis.show', compact('servis'));
    }
}
