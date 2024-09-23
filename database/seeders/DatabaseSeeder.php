<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Jurusan::factory()->create([
            'nama'=> 'ELEKTRO',
        ]);
        Jurusan::factory()->create([
            'nama'=> 'Lainnya',
        ]);
        Kategori::factory()->create([
            'nama'=> 'Pendidikan dan Pengajaran',
        ]);
        Kategori::factory()->create([
            'nama'=> 'Penelitian dan Pengembangan',
        ]);
        Kategori::factory()->create([
            'nama'=> 'Pengabdian Kepada Masyarakat',
        ]);
        Kategori::factory()->create([
            'nama'=> 'Lainnya',
        ]);
    }
}
