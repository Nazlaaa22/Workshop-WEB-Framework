<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')->get();
        return view('vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor'
        ]);

        return redirect('/vendor');
    }

    public function edit($id)
    {
        $vendor = User::find($id);
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = User::find($id);

        $vendor->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/vendor');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/vendor');
    }

    public function scanQr()
    {
        return view('vendor.scan_qr');
    }

    public function getPesanan($id)
    {
        try {
            $pesanan = DB::table('pesanan')
                ->where('idpesanan', $id)
                ->first();

            if (!$pesanan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $pesanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}