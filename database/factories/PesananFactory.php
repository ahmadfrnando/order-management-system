<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_meja' => $this->faker->numberBetween(1, 10),
            'no_pesanan' => $this->faker->numberBetween(1, 100),
            'nama_pemesan' => $this->faker->name(),
            'jam' => $this->faker->time(),
            'tanggal' => $this->faker->date(),
            'total_harga' => $this->faker->numberBetween(10000, 100000),
            'catatan' => $this->faker->sentence(1),
        ];
    }
}
