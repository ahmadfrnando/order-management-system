<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $pesanan = Pesanan::with('pesanan_detail.menu')->findOrFail($id);
        return Inertia::render('Pesanan/Index', [
            'pesanan' => $pesanan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $pesanan = Pesanan::with('pesanan_detail.menu')->findOrFail($id);
        // return Inertia::render('Pesanan/Detail', [
        //     'pesanan' => $pesanan
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        DB::beginTransaction();
        try {
            foreach ($request->pesanan_detail as $detail) {
                $pesananDetail = $pesanan->pesanan_detail()->where('id', $detail['id'])->first();
                if ($pesananDetail) {
                    $pesananDetail->update([
                        'jumlah' => $detail['jumlah']
                    ]);
                }
            }
            $totalHarga = $pesanan->pesanan_detail()->with('menu')->get()->sum(function($d) {
                return $d->jumlah * $d->menu->price;
            });
    
            $pesanan->update([
                'total_harga' => $totalHarga,
                'is_done' => true
            ]);
            DB::commit();
            return redirect()->route('dashboard')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Pesanan telah selesai dibuat!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pesanan.index')->with([
                'flash' => [
                    'type' => 'danger',
                    'message' => 'Pesanan gagal disimpan!' . $th->getMessage()
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
