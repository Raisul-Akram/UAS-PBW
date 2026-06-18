<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servis;
use App\Models\Pelanggan;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function index()
    {
        $stats = [
            'total_servis' => Servis::count(),
            'servis_antri' => Servis::where('status', 'antri')->count(),
            'servis_proses' => Servis::where('status', 'diproses')->count(),
            'servis_selesai' => Servis::where('status', 'selesai')->count(),
            'servis_diambil' => Servis::where('status', 'diambil')->count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_teknisi' => Teknisi::where('status_aktif', true)->count(),
        ];

        // 5 Servis terbaru yang masuk
        $recentServices = Servis::with(['pelanggan.user', 'teknisi'])
            ->latest('tgl_masuk')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentServices'));
    }
}
