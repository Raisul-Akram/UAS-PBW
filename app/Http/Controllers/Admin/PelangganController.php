<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Tampilkan daftar pelanggan.
     */
    public function index()
    {
        $pelanggans = Pelanggan::with('user')->latest()->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Tampilkan detail pelanggan beserta riwayat servisnya.
     */
    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load(['user', 'servis' => function ($q) {
            $q->latest('tgl_masuk');
        }]);

        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    /**
     * Tampilkan form edit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $pelanggan->load('user');
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Perbarui data pelanggan (dan user-nya).
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $user = $pelanggan->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'required|regex:/^08[0-9]{8,11}$/',
            'alamat' => 'required|string',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid (harus diawali 08 dan berjumlah 10-13 digit).',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            // Update data user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update data pelanggan
            $pelanggan->update([
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()->route('admin.pelanggan.index')
                ->with('success', 'Data pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
