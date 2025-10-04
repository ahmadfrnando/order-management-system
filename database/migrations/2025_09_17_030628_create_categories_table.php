<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        $categories = [
            [
                'id' => 1,
                'name' => 'Coffee',
                'slug' => 'coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Drinks',
                'slug' => 'drinks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        //Pesanan gagal disimpan!SQLSTATE[42S22]: Column not found: 1054 Unknown column 'category_id' in 'field list' (Connection: mysql, SQL: insert into `pesanan_detail_riwayat` (`pesanan_riwayat_id`, `nama_menu`, `category_id`, `nama_kategori`, `harga`, `jumlah`, `updated_at`, `created_at`) values (1, mollitia, 2, Drinks, 26248.00, 8, 2025-10-04 07:46:04, 2025-10-04 07:46:04))

        if (!DB::table('categories')->insert($categories)) {
            throw new \Exception('Gagal menambahkan data categories');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
