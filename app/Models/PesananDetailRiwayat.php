<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetailRiwayat extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail_riwayat';
    protected $guarded = [];

    public function pesanan_riwayat()
    {
        return $this->belongsTo(PesananRiwayat::class, 'pesanan_riwayat_id', 'id');
    }
}
