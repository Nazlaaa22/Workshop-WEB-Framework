<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
    public function guest()
    {
        return view('antrian.guest');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'poli' => 'required'
        ]);

        // PREFIX BERDASARKAN POLI
        $prefix = match($request->poli){
            'Poli Umum' => 'U',
            'Poli Gigi' => 'G',
            'Poli Anak' => 'A',
            'Poli Jantung' => 'J',
            'Poli Kandungan' => 'K',
        };

        // CARI NOMOR TERAKHIR
        $last = Antrian::where('kode_antrian', 'like', $prefix.'%')
                    ->latest()
                    ->first();

        if($last){

            $num = (int) substr($last->kode_antrian, 1) + 1;

        } else {

            $num = 1;
        }

        $kode = $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);

        // SIMPAN DATA
        $antrian = Antrian::create([
            'kode_antrian' => $kode,
            'nama_pasien' => $request->nama_pasien,
            'poli' => $request->poli,
            'status' => 'menunggu'
        ]);

        // TAMPILKAN HALAMAN HASIL
        return view('antrian.hasil', compact('antrian'));
    }

    public function stream()
    {
        return response()->stream(function () {

            while (true) {

                $antrian = Antrian::latest()->get();

                echo "data: " . json_encode($antrian) . "\n\n";

                ob_flush();
                flush();

                if (connection_aborted()) {
                    break;
                }

                sleep(1);
            }

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}