<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan_detail_riwayat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_riwayat_id');
            $table->unsignedBigInteger('menu_id');
            $table->string('nama_menu');
            $table->decimal('harga', 12, 2);
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail_riwayat');
    }
};
