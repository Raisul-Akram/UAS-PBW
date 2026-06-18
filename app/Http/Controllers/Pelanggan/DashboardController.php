<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard pelanggan.
     */
    public function index()
    {
        $user = auth()->user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            // Pengamanan darurat jika relasi pelanggan kosong (misalnya admin yang mencoba rute ini)
            return redirect()->route('admin.dashboard');
        }

        $stats = [
            'total_servis' => $pelanggan->servis()->count(),
            'servis_aktif' => $pelanggan->servis()->whereIn('status', ['antri', 'diproses'])->count(),
            'servis_selesai' => $pelanggan->servis()->whereIn('status', ['selesai', 'diambil'])->count(),
        ];

        // Ambil 3 servis terbaru milik pelanggan
        $recentServices = $pelanggan->servis()
            ->with('teknisi')
            ->latest('tgl_masuk')
            ->limit(3)
            ->get();

        return view('pelanggan.dashboard', compact('stats', 'recentServices'));
    }
}
