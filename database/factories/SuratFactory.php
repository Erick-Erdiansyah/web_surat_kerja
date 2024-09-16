<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surat>
 */
class SuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file' => fake()->word() . '.pdf',
            'judul' => fake()->sentence(),
            'tahun_ajaran' => '2023-2024',
            'user_id' => \App\Models\User::factory(),
            'prodi_id' => \App\Models\Prodi::factory(),
        ];
    }
}
