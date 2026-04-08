<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('status_bayar', 1)->get();

        return view('pesanan.index', compact('pesanan'));
    }
}