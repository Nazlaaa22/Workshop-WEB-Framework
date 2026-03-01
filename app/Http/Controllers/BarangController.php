<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('id_barang', 'asc')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga
        ]);

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil dihapus');
    }

    public function print(Request $request)
    {
        $request->validate([
            'barang_ids' => 'required|array',
            'start_x' => 'required|integer|min:1|max:5',
            'start_y' => 'required|integer|min:1|max:8',
        ]);

        $barang = Barang::whereIn('id_barang', $request->barang_ids)->get();

        $startPosition = (($request->start_y - 1) * 5) + ($request->start_x - 1);

        $pdf = Pdf::loadView('barang.label', [
            'barang' => $barang,
            'startPosition' => $startPosition
        ])->setPaper('a4');

        return $pdf->stream('label.pdf');
    }
}