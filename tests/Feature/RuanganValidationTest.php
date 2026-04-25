<?php

namespace Tests\Feature;

use Tests\TestCase;

class RuanganValidationTest extends TestCase
{
    /**
     * Test case 1: POST (Tambah) gagal jika kapasitas 0
     */
    public function test_tambah_ruangan_gagal_jika_kapasitas_nol()
    {
        $response = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson('/ruangan', [
                'name' => 'Ruang Rapat',
                'floor' => 'Lantai 1',
                'capacity' => 0, // Sengaja disalahkan
                'description' => 'Ada proyektor'
            ]);
        
        // Memastikan Laravel menolak request karena validasi gagal (status 422)
        $response->assertStatus(422); 
        $response->assertJsonValidationErrors(['capacity']);
    }

    /**
     * Test case 2: PUT (Edit) gagal jika kapasitas 0
     */
    public function test_update_ruangan_gagal_jika_kapasitas_nol()
    {
        // Asumsi ada ruangan dengan ID 1 untuk ditest
        $response = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->putJson('/ruangan/1', [
                'name' => 'Aula',
                'floor' => 'Lantai 2',
                'capacity' => 0, 
                'description' => 'Ruang besar'
            ]);
        
        $response->assertStatus(422); 
        $response->assertJsonValidationErrors(['capacity']);
    }

    /**
     * Test case 3: POST berhasil jika data valid
     */
    public function test_tambah_ruangan_berhasil_jika_kapasitas_minimal_satu()
    {
        $response = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->post('/ruangan', [
                'name' => 'Ruang Testing Valid',
                'floor' => 'Lantai 1',
                'capacity' => 10, // Data valid
                'description' => 'Test doang'
            ]);
            
        $response->assertSessionHasNoErrors(['capacity']);
    }
}