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
        Schema::create('pesanan_riwayat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->string('no_pesanan')->unique();
            $table->string('no_meja');
            $table->string('nama_pemesan');
            $table->time('jam');
            $table->date('tanggal');
            $table->decimal('total_harga', 12, 2);
            $table->integer('total_item');
            $table->text('catatan')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_riwayat');
    }
};
