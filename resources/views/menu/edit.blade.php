@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Edit Menu</h3>

    <form action="/menu/{{ $menu->idmenu }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" class="form-control mb-2">
        <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control mb-2">

        <input type="file" name="gambar" class="form-control mb-2">

        <button class="btn btn-success">Update</button>
    </form>
</div>

@endsection