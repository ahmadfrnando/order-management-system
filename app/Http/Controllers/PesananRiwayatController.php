<?php

namespace App\Http\Controllers;

use App\Models\PesananDetailRiwayat;
use App\Models\PesananRiwayat;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananRiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): Response
    {
        $riwayat = PesananRiwayat::all();
        return Inertia::render('Riwayat/Index', [
            'riwayat' => $riwayat
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $riwayat = PesananRiwayat::with('pesanan_detail_riwayat')->findOrFail($id);
        return Inertia::render('Riwayat/Show', [
            'riwayat' => $riwayat
        ]);
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

    public function cetak(PesananRiwayat $pesanan)
    {   
        $pdf = Pdf::loadView('pdf.invoice', compact('pesanan'));
        return $pdf->stream('invoice_' . $pesanan->id . '_' . $pesanan->nama_pemesan . '.pdf');
    }
}
