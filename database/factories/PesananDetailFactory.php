<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PesananDetail>
 */
class PesananDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            'pesanan_id' => 1,
            'menu_id' => Menu::find(1)->id,
            'nama_menu' => Menu::find(1)->name,
            'jumlah' => $this->faker->numberBetween(1, 10),
            'harga' => $this->faker->numberBetween(10000, 100000)
        ];
    }
}
