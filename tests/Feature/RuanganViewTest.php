<?php

namespace Tests\Feature;

use Tests\TestCase;

class RuanganViewTest extends TestCase
{
    // Fungsi ini buat matiin proteksi login sementara
    protected function setUp(): void
    {
        parent::setUp();
        // Bypass middleware auth 
        $this->withoutMiddleware();
    }

    /**
     * Test case 1: Pastikan halaman bisa diakses (Status 200)
     */
    public function test_halaman_index_ruangan_berhasil_dimuat()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertStatus(200);
        $response->assertSee('Sewa Ruangan');
    }

    /**
     * Test case 2: Pastikan input search ada di HTML
     */
    public function test_terdapat_input_pencarian_untuk_javascript()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertSee('id="roomSearch"', false);
        $response->assertSee('placeholder="Cari nama ruangan atau lantai..."', false);
    }

    /**
     * Test case 3: Pastikan dropdown filter status ada dengan opsi yang benar
     */
    public function test_terdapat_dropdown_filter_status_ruangan()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        
        $response->assertSee('id="roomStatusFilter"', false);
        $response->assertSee('value="all"', false);
        $response->assertSee('value="tersedia"', false);
        $response->assertSee('value="dipakai"', false);
    }

/**
     * Test case 4: Edge Case - Pastikan tampilan aman saat tidak ada data ruangan
     */
    public function test_tampilan_saat_data_ruangan_kosong_menampilkan_pesan_yang_sesuai()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
                         ->get('/ruangan');
        $response->assertSee('Belum ada ruangan tersedia');
        $response->assertSee('fa-building'); 
    }
}