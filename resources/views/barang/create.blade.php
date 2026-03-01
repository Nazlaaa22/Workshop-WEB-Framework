@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Barang</h3>

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            Simpan
        </button>
    </form>
</div>
@endsection