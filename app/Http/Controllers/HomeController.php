<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NfcLog;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role == 'vendor') {
            return redirect('/vendor-dashboard');
        }

        if (auth()->user()->role == 'adminRS') {
            return redirect('/admin-dashboard');
        }

        return view('dashboard');
    }

    public function saveNfc(Request $request)
    {
        NfcLog::create([
            'serial_number' => $request->serial_number,
            'waktu_scan' => now()
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function registerNfc(Request $request)
    {
        KartuNfc::create([

            'nama' => $request->nama,

            'serial_number' =>
                $request->serial_number

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Kartu berhasil didaftarkan'

        ]);
    }
}
