<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananRiwayat extends Model
{
    use HasFactory;
    protected $table = 'pesanan_riwayat';
    protected $guarded = [];

    public function pesanan_detail_riwayat()
    {
        return $this->hasMany(PesananDetailRiwayat::class, 'pesanan_riwayat_id', 'id');
    }
}
