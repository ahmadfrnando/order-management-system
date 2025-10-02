<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PesananRiwayat>
 */
class PesananRiwayatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            'pesanan_id' => \App\Models\Pesanan::find(1)->id,
            'no_meja' =>  \App\Models\Pesanan::find(1)->no_meja,
            'no_pesanan' =>  \App\Models\Pesanan::find(1)->no_pesanan,
            'nama_pemesan' =>  \App\Models\Pesanan::find(1)->nama_pemesan,
            'jam' =>  \App\Models\Pesanan::find(1)->jam,
            'tanggal' => \App\Models\Pesanan::find(1)->tanggal,
            'total_harga' => \App\Models\Pesanan::find(1)->total_harga,
            'total_item' => \App\Models\Pesanan::find(1)->total_item,
            'catatan' => \App\Models\Pesanan::find(1)->catatan,
        ];
    }
}
