<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function create2()
    {
        return view('admin.customer.create2');
    }

    public function store2(Request $request)
    {
        $image = $request->foto;

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = base64_decode($image);

        $filename = 'customer_' . time() . '.png';

        if (!Storage::exists('public/customer')) {
            Storage::makeDirectory('public/customer');
        }

        Storage::disk('public')->put('customer/' . $filename, $image);

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kodepos' => $request->kodepos,
            'foto_path' => 'customer/'.$filename
        ]);

        return redirect('/admin/customer');
    }

    public function create1()
    {
        return view('admin.customer.create1');
    }

    public function store1(Request $request)
    {
        $image = $request->foto;
        $image = str_replace('data:image/png;base64,', '', $image);

        DB::table('customers')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kodepos' => $request->kodepos,
            'foto_blob' => DB::raw("decode('".$image."', 'base64')"),

            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/admin/customer');
    }
}