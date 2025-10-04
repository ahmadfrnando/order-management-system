<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\PesananDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PesananDetailRiwayat>
 */
class PesananDetailRiwayatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $pesananDetail = PesananDetail::find(1);
        return [
            'pesanan_riwayat_id' => 1,
            'nama_menu' => Menu::find(1)->name,
            'menu_id' => Menu::find(1)->id,
            'kategori_id' => Menu::find(1)->kategori_id,
            'nama_kategori' => Menu::find(1)->kategori->name,
            'jumlah' => $pesananDetail->jumlah,
            'harga' => $pesananDetail->harga
        ];
    }
}
