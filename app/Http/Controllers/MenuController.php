<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::where('user_id', auth()->id())->get();
        return view('menu.index', compact('menu'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('menu', 'public');
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'path_gambar' => $gambar,
            'user_id' => auth()->id()
        ]);

        return redirect('/menu');
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('menu', 'public');
            $menu->path_gambar = $gambar;
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga
        ]);

        return redirect('/menu');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect('/menu');
    }
}