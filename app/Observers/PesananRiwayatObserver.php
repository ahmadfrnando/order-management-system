<?php

namespace App\Observers;

use App\Models\PesananDetail;
use App\Models\PesananDetailRiwayat;
use App\Models\PesananRiwayat;

class PesananRiwayatObserver
{
    /**
     * Handle the PesananRiwayat "created" event.
     */
    public function created(PesananRiwayat $pesananRiwayat): void
    {
        $pesananDetail = PesananDetail::where('pesanan_id', $pesananRiwayat->pesanan_id)->get();
        foreach ($pesananDetail as $value) {
            if (!is_null($value->menu)) {
                $pesananDetailRiwayat = PesananDetailRiwayat::find($value->menu_id);
                if (!$pesananDetailRiwayat) {
                    PesananDetailRiwayat::create([
                        'pesanan_riwayat_id'   => $pesananRiwayat->id,
                        'nama_menu'      => $value->nama_menu,
                        'menu_id'      => $value->menu_id,
                        'kategori_id'      => $value->menu->category_id,
                        'nama_kategori'      => $value->menu->category->name,
                        'harga'      => $value->harga,
                        'jumlah'      => $value->jumlah
                    ]);
                } else {
                    $pesananRiwayat->pesanan_detail_riwayat()->update([
                        'pesanan_riwayat_id'   => $pesananRiwayat->id,
                        'nama_menu'      => $value->nama_menu,
                        'menu_id'      => $value->menu_id,
                        'kategori_id'      => $value->menu->category_id,
                        'nama_kategori'      => $value->menu->category->name,
                        'harga'      => $value->harga,
                        'jumlah'      => $value->jumlah
                    ]);
                }
            }
        }
    }

    /**
     * Handle the PesananRiwayat "updated" event.
     */
    public function updated(PesananRiwayat $pesananRiwayat): void
    {
        //
    }

    /**
     * Handle the PesananRiwayat "deleted" event.
     */
    public function deleted(PesananRiwayat $pesananRiwayat): void
    {
        //
    }

    /**
     * Handle the PesananRiwayat "restored" event.
     */
    public function restored(PesananRiwayat $pesananRiwayat): void
    {
        //
    }

    /**
     * Handle the PesananRiwayat "force deleted" event.
     */
    public function forceDeleted(PesananRiwayat $pesananRiwayat): void
    {
        //
    }
}
