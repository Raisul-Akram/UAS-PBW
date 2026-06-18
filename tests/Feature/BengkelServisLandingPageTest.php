<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BengkelServisLandingPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji coba halaman landing page Bengkel Servis dapat diakses dengan sukses.
     */
    public function test_bengkel_servis_landing_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Servis Elektronik');
        $response->assertSee('Mudah');
        $response->assertSee('Transparan');
        $response->assertSee('Login');
        $response->assertSee('Daftar Sekarang');
        $response->assertSee('BENGKEL SERVIS');
    }
}
