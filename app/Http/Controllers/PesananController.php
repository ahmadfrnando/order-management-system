<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

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
        $pesanan = Pesanan::findOrFail($request->id);
        DB::beginTransaction();
        try {
            foreach ($request->pesanan_detail as $detail) {
                $menu = Menu::find($detail['menu_id']);
                if (!$menu) {
                    throw new \Exception('Menu tidak ditemukan');
                }

                $pesananDetail = $pesanan->pesanan_detail()->where('menu_id', $detail['menu_id'])->first();
                if ($pesananDetail) {
                    $pesananDetail->update([
                        'jumlah' => $detail['jumlah']
                    ]);
                } else {
                    $pesanan->pesanan_detail()->create([
                        'menu_id' => $detail['menu_id'],
                        'jumlah' => $detail['jumlah'],
                        'harga' => $menu->price,
                        'nama_menu' => $menu->name,
                        'pesanan_id' => $pesanan->id
                    ]);
                }
            }
            $totalHarga = $pesanan->pesanan_detail()->with('menu')->get()->sum(function($d) {
                return $d->jumlah * $d->menu->price;
            });

            $totalItem = $pesanan->pesanan_detail()->sum('jumlah');    
            $pesanan->update([
                'total_harga' => $totalHarga,
                'total_item' => $totalItem
            ]);
            DB::commit();
            return redirect()->route('pesanan.index', [$pesanan->id])->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Pesanan telah selesai diubah!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pesanan.edit', [$pesanan->id])->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Pesanan gagal diubah!' . $th->getMessage()
                ]
            ]);
        }
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
    public function edit(string $id): Response
    {
        $pesanan = Pesanan::with('pesanan_detail.menu')->findOrFail($id);
        $menu = Menu::all();
        return Inertia::render('Pesanan/Edit', [
            'pesanan' => $pesanan,
            'menu' => $menu
        ]);
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

            $totalItem = $pesanan->pesanan_detail()->sum('jumlah');
    
            $pesanan->update([
                'total_harga' => $totalHarga,
                'is_done' => true,
                'total_item' => $totalItem
            ]);
            DB::commit();
            return redirect()->route('riwayat.show', [$pesanan->pesanan_riwayat->id])->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Pesanan telah selesai dibuat!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pesanan.index', [$pesanan->id])->with([
                'flash' => [
                    'type' => 'error',
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
        $pesanan = Pesanan::findOrFail($id);
        try {
            $pesanan->pesanan_detail()->delete();
            $pesanan->delete();
            return redirect()->route('dashboard')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Pesanan berhasil dibatalkan!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('dashboard')->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Pesanan gagal dibatalkan!' . $th->getMessage()
                ]
            ]);
        }
    }
}
