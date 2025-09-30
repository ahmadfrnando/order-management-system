<?php

namespace App\Http\Controllers;

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
                'waktu' => now(),
                'tanggal' => now(),
                'total_harga' => $total_harga,
                'status' => false,
                'catatan' => $validated['catatan'] ?? null
            ]);

            foreach ($validated['items'] as  $item) {
                $menu = Menu::find($item['id']);

                if (!$menu) {
                    throw new \Exception('Menu tidak ditemukan');
                }
                
                for ($i = 0; $i < $item['qty']; $i++) {
                    PesananDetail::create([
                        'pesanan_id' => $pesanan->id,
                        'menu_id' => $menu->id,
                        'harga' => $menu->harga
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('home')->with('success', 'Pesanan berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            return redirect()->route('home')->with('error', $th->getMessage());
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
