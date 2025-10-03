<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $guarded = [];

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class);
    }

    public function pesanan_riwayat()
    {
        return $this->hasOne(PesananRiwayat::class);
    }

    public static function generateNoPesanan()
    {
        $lastPesanan = Pesanan::whereDate('tanggal', now()->toDateString())
            ->latest('id')
            ->first();

        $lastId = $lastPesanan?->id ?? 0;
        $countToday = Pesanan::whereDate('tanggal', now()->toDateString())->count();
        $noUrut = str_pad($countToday + 1, 2, '0', STR_PAD_LEFT);
        $tanggal = now()->format('d');
        $jam     = now()->format('H');
        return "TS{$tanggal}{$jam}{$noUrut}{$lastId}";
    }
}
