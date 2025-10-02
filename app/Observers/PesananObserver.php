<?php

namespace App\Observers;

use App\Models\Pesanan;
use App\Models\PesananRiwayat;

class PesananObserver
{
    /**
     * Handle the Pesanan "created" event.
     */
    public function created(Pesanan $pesanan): void
    {
      //
    }

    /**
     * Handle the Pesanan "updated" event.
     */
    public function updated(Pesanan $pesanan): void
    {
        if ($pesanan->isDirty('is_done') && $pesanan->is_done) {
            PesananRiwayat::create([
                'pesanan_id'   => $pesanan->id,
                'nama_pemesan' => $pesanan->nama_pemesan,
                'no_meja'      => $pesanan->no_meja,
                'catatan'      => $pesanan->catatan,
                'is_done'      => $pesanan->is_done,
                'no_pesanan'   => $pesanan->no_pesanan,
                'total_harga'  => $pesanan->total_harga,
                'total_item'   => $pesanan->total_item,
                'tanggal'      => $pesanan->tanggal,
                'jam'          => $pesanan->jam
            ]);
        }
    }

    /**
     * Handle the Pesanan "deleted" event.
     */
    public function deleted(Pesanan $pesanan): void
    {
        //
    }

    /**
     * Handle the Pesanan "restored" event.
     */
    public function restored(Pesanan $pesanan): void
    {
        //
    }

    /**
     * Handle the Pesanan "force deleted" event.
     */
    public function forceDeleted(Pesanan $pesanan): void
    {
        //
    }
}
