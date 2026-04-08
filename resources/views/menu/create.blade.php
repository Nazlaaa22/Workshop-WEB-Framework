@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Tambah Menu</h3>

    <form action="/menu" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="nama_menu" class="form-control mb-2" placeholder="Nama Menu">
        <input type="number" name="harga" class="form-control mb-2" placeholder="Harga">

        <input type="file" name="gambar" class="form-control mb-2">

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

@endsection