<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Buku::with('kategori')->get();
        return view('buku.index', compact('data'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idkategori' => 'required',
            'kode' => 'required',
            'judul' => 'required',
            'pengarang' => 'required'
        ]);

        Buku::create([
            'idkategori' => $request->idkategori,
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang
        ]);

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $buku->update([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Buku::findOrFail($id);
        $data->delete();

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil dihapus');
    }
}