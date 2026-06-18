<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Servis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BengkelServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji coba user yang belum login diblokir dari akses panel admin dan pelanggan.
     */
    public function test_unauthenticated_user_cannot_access_portals(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/pelanggan/dashboard')->assertRedirect('/login');
    }

    /**
     * Uji coba pelanggan biasa diblokir dari admin panel (403).
     */
    public function test_customer_cannot_access_admin_portal(): void
    {
        $customerUser = User::factory()->create(['role' => 'pelanggan']);
        
        $response = $this->actingAs($customerUser)->get('/admin/dashboard');
        
        $response->assertStatus(403);
    }

    /**
     * Uji coba admin dapat mengakses dashboard admin.
     */
    public function test_admin_can_access_admin_portal(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($adminUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
    }

    /**
     * Uji coba alur redirect /dashboard berdasarkan role - ADMIN.
     */
    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($adminUser)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Uji coba alur redirect /dashboard berdasarkan role - PELANGGAN.
     */
    public function test_customer_is_redirected_to_customer_dashboard(): void
    {
        $customerUser = User::factory()->create(['role' => 'pelanggan']);
        // Buat relasi pelanggan
        Pelanggan::create([
            'user_id' => $customerUser->id,
            'no_hp' => '081234567890',
            'alamat' => 'Alamat Rumah Test',
        ]);

        $response = $this->actingAs($customerUser)->get('/dashboard');

        $response->assertRedirect(route('pelanggan.dashboard'));
    }

    /**
     * Uji coba proteksi IDOR: pelanggan tidak bisa melihat detail servis pelanggan lain.
     */
    public function test_customer_cannot_view_others_service_details_idor(): void
    {
        // Pelanggan A
        $userA = User::factory()->create(['role' => 'pelanggan']);
        $pelangganA = Pelanggan::create(['user_id' => $userA->id, 'no_hp' => '081234567890', 'alamat' => 'A']);
        $userA->refresh();

        // Pelanggan B
        $userB = User::factory()->create(['role' => 'pelanggan']);
        $pelangganB = Pelanggan::create(['user_id' => $userB->id, 'no_hp' => '081234567891', 'alamat' => 'B']);
        $userB->refresh();

        // Servis milik Pelanggan B
        $servisB = Servis::create([
            'kode_servis' => 'SRV-20260602-0001',
            'pelanggan_id' => $pelangganB->id,
            'nama_perangkat' => 'Laptop Asus B',
            'jenis_kerusakan' => 'Rusak Keyboard B',
            'estimasi_biaya' => 150000,
            'tgl_estimasi_selesai' => '2026-06-10',
            'tgl_masuk' => now(),
            'status' => 'antri',
        ]);

        // Pelanggan A mencoba melihat detail servis Pelanggan B
        $response = $this->actingAs($userA)->get("/pelanggan/servis/{$servisB->id}");

        // Harus mengembalikan status 403 (Akses Ditolak/Forbidden)
        $response->assertStatus(403);
    }

    /**
     * Uji coba pelanggan dapat melihat detail servis miliknya sendiri.
     */
    public function test_customer_can_view_own_service_details(): void
    {
        $user = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create(['user_id' => $user->id, 'no_hp' => '081234567890', 'alamat' => 'Alamat']);
        $user->refresh();

        $servis = Servis::create([
            'kode_servis' => 'SRV-20260602-0002',
            'pelanggan_id' => $pelanggan->id,
            'nama_perangkat' => 'Laptop Asus',
            'jenis_kerusakan' => 'Keyboard Rusak',
            'estimasi_biaya' => 150000,
            'tgl_estimasi_selesai' => '2026-06-10',
            'tgl_masuk' => now(),
            'status' => 'antri',
        ]);

        $response = $this->actingAs($user)->get("/pelanggan/servis/{$servis->id}");

        $response->assertStatus(200);
        $response->assertSee('Laptop Asus');
    }

    /**
     * Uji coba admin dapat memperbarui status servis dan biaya final tanpa terjadi inflasi nilai.
     */
    public function test_admin_can_update_service_status_and_biaya_final(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $customerUser = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create(['user_id' => $customerUser->id, 'no_hp' => '081234567890', 'alamat' => 'Alamat']);

        $servis = Servis::create([
            'kode_servis' => 'SRV-20260602-0003',
            'pelanggan_id' => $pelanggan->id,
            'nama_perangkat' => 'Laptop Asus',
            'jenis_kerusakan' => 'Keyboard Rusak',
            'estimasi_biaya' => 150000,
            'tgl_estimasi_selesai' => '2026-06-10',
            'tgl_masuk' => now(),
            'status' => 'antri',
        ]);
        // Simpan perubahan pertama dengan input "160.000" (dengan pemisah ribuan)
        $response1 = $this->actingAs($adminUser)->patch("/admin/servis/{$servis->id}", [
            'status' => 'diambil',
            'estimasi_biaya' => '150.000',
            'biaya_final' => '160.000',
            'catatan_teknisi' => 'Sudah diperbaiki dan diambil.',
        ]);

        $response1->assertRedirect(route('admin.servis.index'));
        
        $servis->refresh();
        $this->assertEquals('diambil', $servis->status);
        $this->assertEquals(160000.00, $servis->biaya_final);

        // Simpan perubahan kedua dengan input yang dihasilkan form (160.000)
        // Ini mensimulasikan submit form edit kembali tanpa mengubah biaya
        $response2 = $this->actingAs($adminUser)->patch("/admin/servis/{$servis->id}", [
            'status' => 'diambil',
            'estimasi_biaya' => number_format($servis->estimasi_biaya, 0, ',', '.'), // Menghasilkan "150.000"
            'biaya_final' => number_format($servis->biaya_final, 0, ',', '.'), // Menghasilkan "160.000"
            'catatan_teknisi' => 'Sudah diperbaiki dan diambil.',
        ]);

        $response2->assertRedirect(route('admin.servis.index'));
        
        $servis->refresh();
        $this->assertEquals(160000.00, $servis->biaya_final); // Nilai harus tetap 160000, tidak naik jadi 16000000
    }
    /**
     * Uji coba admin dapat memperbarui estimasi biaya dan tidak terjadi inflasi nilai.
     */
    public function test_admin_can_update_estimasi_biaya(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $customerUser = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create(['user_id' => $customerUser->id, 'no_hp' => '081234567890', 'alamat' => 'Alamat']);

        $servis = Servis::create([
            'kode_servis' => 'SRV-20260602-0004',
            'pelanggan_id' => $pelanggan->id,
            'nama_perangkat' => 'Laptop Asus',
            'jenis_kerusakan' => 'Keyboard Rusak',
            'estimasi_biaya' => 100000,
            'tgl_estimasi_selesai' => '2026-06-10',
            'tgl_masuk' => now(),
            'status' => 'antri',
        ]);

        // Simpan perubahan pertama dengan input "250.000" (dengan pemisah ribuan)
        $response1 = $this->actingAs($adminUser)->patch("/admin/servis/{$servis->id}", [
            'status' => 'diproses',
            'estimasi_biaya' => '250.000',
            'biaya_final' => '',
            'catatan_teknisi' => 'Menunggu diagnosa.',
        ]);

        $response1->assertRedirect(route('admin.servis.index'));
        
        $servis->refresh();
        $this->assertEquals('diproses', $servis->status);
        $this->assertEquals(250000.00, $servis->estimasi_biaya);

        // Simpan perubahan kedua dengan input yang dihasilkan form (250.000)
        $response2 = $this->actingAs($adminUser)->patch("/admin/servis/{$servis->id}", [
            'status' => 'diproses',
            'estimasi_biaya' => number_format($servis->estimasi_biaya, 0, ',', '.'), // Menghasilkan "250.000"
            'biaya_final' => '',
            'catatan_teknisi' => 'Menunggu diagnosa.',
        ]);

        $response2->assertRedirect(route('admin.servis.index'));
        
        $servis->refresh();
        $this->assertEquals(250000.00, $servis->estimasi_biaya); // Nilai harus tetap 250000
    }
}
