@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Menu Saya</h3>

    <a href="/menu/create" class="btn btn-primary mb-3">Tambah Menu</a>

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>

        @foreach($menu as $m)
        <tr>
            <td>{{ $m->nama_menu }}</td>
            <td>{{ $m->harga }}</td>
            <td>
                @if($m->path_gambar)
                    <img src="{{ asset('storage/' . $m->path_gambar) }}" width="80">
                @endif
            </td>
            <td>
                <a href="/menu/{{ $m->idmenu }}/edit" class="btn btn-warning btn-sm">Edit</a>

                <form action="/menu/{{ $m->idmenu }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection