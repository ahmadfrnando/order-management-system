<?php

namespace App\Http\Controllers;

use App\Events\PesananBaruDibuat;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $coffee = Menu::where('category_id', 1)->get();
        $drinks = Menu::where('category_id', 2)->get();
        return Inertia::render('Home', [
            'coffees' => $coffee,
            'drinks' => $drinks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        $validated = $request->validate([
            'nama_pemesan' => 'required|max:255',
            'no_meja' => 'required|numeric',
            'catatan' => 'nullable|max:255',
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            $total_harga = collect($validated['items'])
                ->sum(fn($item) => $item['qty'] * $item['price']);

            $pesanan = Pesanan::create([
                'nama_pemesan' => $validated['nama_pemesan'],
                'no_meja' => $validated['no_meja'],
                'jam' => now()->format('H:i:s'),
                'tanggal' => now()->format('Y-m-d'),
                'total_harga' => $total_harga,
                'total_item' => (count($validated['items']) * $validated['items'][0]['qty']) ?? 0,
                'catatan' => $validated['catatan'],
                'no_pesanan' => Pesanan::generateNoPesanan()
            ]);

            foreach ($validated['items'] as  $item) {
                $menu = Menu::find($item['id']);

                if (!$menu) {
                    throw new \Exception('Menu tidak ditemukan');
                }
                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu->id,
                    'nama_menu' => $menu->name,
                    'harga' => $item['qty'] * $menu->price,
                    'jumlah' => $item['qty']
                ]);
            }

            DB::commit();
            return redirect()->route('home')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Pesanan berhasil disimpan!'
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            return redirect()->route('home')->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Maaf pesanan gagal disimpan!' . $th->getMessage()
                ]
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
