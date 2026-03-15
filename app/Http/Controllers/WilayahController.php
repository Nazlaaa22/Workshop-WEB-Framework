<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index()
    {
        return view('wilayah.index');
    }

    public function provinsi()
    {
        return DB::table('provinces')->get();
    }

    public function kota($id)
    {
        return DB::table('regencies')
                ->where('province_id', $id)
                ->get();
    }

    public function kecamatan($id)
    {
        return DB::table('districts')
                ->where('regency_id', $id)
                ->get();
    }

    public function kelurahan($id)
    {
        return DB::table('villages')
                ->where('district_id', $id)
                ->get();
    }
}
