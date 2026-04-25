<?php

namespace Tests\Feature;

use Tests\TestCase;

class RuanganValidationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_tambah_ruangan_gagal_jika_kapasitas_nol()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
            ->postJson('/ruangan', [
                'name' => 'Ruang Rapat',
                'floor' => 'Lantai 1',
                'capacity' => 0,
                'description' => 'Ada proyektor'
            ]);
        
        $response->assertStatus(422); 
    }

    public function test_update_ruangan_gagal_jika_kapasitas_nol()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
            ->putJson('/ruangan/1', [
                'name' => 'Aula',
                'floor' => 'Lantai 2',
                'capacity' => 0,
                'description' => 'Ruang besar'
            ]);
        
        $response->assertStatus(422); 
    }

    public function test_tambah_ruangan_berhasil_jika_kapasitas_minimal_satu()
    {
        $response = $this->withSession(['user' => ['role' => 'admin']])
            ->post('/ruangan', [
                'name' => 'Ruang Testing Valid',
                'floor' => 'Lantai 1',
                'capacity' => 10,
                'description' => 'Test doang'
            ]);
            
        $response->assertSessionHasNoErrors(['capacity']);
    }
}