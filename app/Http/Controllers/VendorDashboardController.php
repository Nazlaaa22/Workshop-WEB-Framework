<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalMenu = Menu::where('user_id', $userId)->count();

        $pesananLunas = \App\Models\Pesanan::where('status_bayar', 1)->count();

        return view('vendor.dashboard', compact('totalMenu', 'pesananLunas'));
    }
}