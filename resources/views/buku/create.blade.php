@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        Tambah Buku
    </h3>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">

        <form id="formBuku" action="{{ route('buku.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label>Kode Buku</label>
                <input type="text"
                       name="kode"
                       value="{{ old('kode') }}"
                       class="form-control"
                       placeholder="Contoh: BK001"
                       required>
            </div>

            <div class="form-group mb-3">
                <label>Judul Buku</label>
                <input type="text"
                       name="judul"
                       value="{{ old('judul') }}"
                       class="form-control"
                       placeholder="Masukkan judul buku"
                       required>
            </div>

            <div class="form-group mb-3">
                <label>Pengarang</label>
                <input type="text"
                       name="pengarang"
                       value="{{ old('pengarang') }}"
                       class="form-control"
                       placeholder="Masukkan nama pengarang"
                       required>
            </div>

            <div class="form-group mb-4">
                <label>Kategori</label>
                <select name="idkategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="button" id="btnSubmitBuku" class="btn btn-gradient-primary me-2">
                Simpan
            </button>

            <a href="{{ route('buku.index') }}"
               class="btn btn-light">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection

@section('script')

<script>
$(document).ready(function(){

    $("#btnSubmitBuku").click(function(){

        let form = document.getElementById("formBuku");

        if(!form.checkValidity()){
            form.reportValidity();
            return;
        }

        $("#btnSubmitBuku").html(
            '<span class="spinner-border spinner-border-sm"></span> Loading...'
        );

        form.submit();

    });

});
</script>

@endsection