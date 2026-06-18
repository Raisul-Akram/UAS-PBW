<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeknisiRequest;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class TeknisiController extends Controller
{
    /**
     * Tampilkan daftar teknisi.
     */
    public function index()
    {
        $teknisis = Teknisi::latest()->paginate(10);
        return view('admin.teknisi.index', compact('teknisis'));
    }

    /**
     * Tampilkan form tambah teknisi.
     */
    public function create()
    {
        return view('admin.teknisi.create');
    }

    /**
     * Simpan data teknisi baru.
     */
    public function store(TeknisiRequest $request)
    {
        Teknisi::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status_aktif' => $request->has('status_aktif') ? $request->status_aktif : true,
        ]);

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Teknisi baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail teknisi (termasuk riwayat servis yang ditangani).
     */
    public function show(Teknisi $teknisi)
    {
        $teknisi->load(['servis' => function ($q) {
            $q->latest('tgl_masuk');
        }]);

        return view('admin.teknisi.show', compact('teknisi'));
    }

    /**
     * Tampilkan form edit teknisi.
     */
    public function edit(Teknisi $teknisi)
    {
        return view('admin.teknisi.edit', compact('teknisi'));
    }

    /**
     * Perbarui data teknisi.
     */
    public function update(TeknisiRequest $request, Teknisi $teknisi)
    {
        $teknisi->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status_aktif' => $request->has('status_aktif') ? (bool)$request->status_aktif : false,
        ]);

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Data teknisi berhasil diperbarui.');
    }

    /**
     * Hapus data teknisi dari database.
     */
    public function destroy(Teknisi $teknisi)
    {
        // Periksa apakah teknisi sedang menangani servis yang aktif
        $activeServis = $teknisi->servis()->whereIn('status', ['antri', 'diproses'])->count();
        if ($activeServis > 0) {
            return redirect()->back()
                ->with('error', 'Teknisi tidak dapat dihapus karena sedang menangani ' . $activeServis . ' servis aktif.');
        }

        $teknisi->delete();

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil dihapus dari database.');
    }
}
