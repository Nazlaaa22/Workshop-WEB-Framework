<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiToko;

class LokasiTokoController extends Controller
{
    public function index()
    {
        $data = LokasiToko::all();

        return view('vendor.lokasi_toko', compact('data'));
    }

    public function store(Request $request)
    {
        LokasiToko::create([
            'barcode' => $request->barcode,
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
        ]);

        return redirect('/kunjungan-toko');
    }

    public function barcode($barcode)
    {
        $toko = LokasiToko::find($barcode);

        return view('vendor.barcode_toko', compact('toko'));
    }
}