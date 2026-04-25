<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\ViewErrorBag;

class RuanganViewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        view()->share('errors', new ViewErrorBag);
    }

    public function test_halaman_index_ruangan_berhasil_dimuat()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertStatus(200);
        $response->assertSee('Sewa Ruangan');
    }

    public function test_terdapat_input_pencarian_untuk_javascript()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertSee('id="roomSearch"', false);
    }

    public function test_terdapat_dropdown_filter_status_ruangan()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertSee('id="roomStatusFilter"', false);
    }

    public function test_tampilan_saat_data_ruangan_kosong_menampilkan_pesan_yang_sesuai()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');

        $response->assertSee('Belum ada ruangan tersedia');
    }
}