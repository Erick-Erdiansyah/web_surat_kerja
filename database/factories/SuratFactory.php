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
            'prodi_id' => random_int(1,3),
        ];
    }
}
