@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title">
        <i class="mdi mdi-pencil-box-outline text-warning me-2"></i>
        Edit Buku
    </h3>

    <a href="{{ route('buku.index') }}" class="btn btn-light btn-sm">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger mt-3">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card mt-3 shadow-sm">
    <div class="card-body">

        <form action="{{ route('buku.update', $buku) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text"
                           name="kode"
                           value="{{ old('kode', $buku->kode) }}"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="idkategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}"
                                {{ $buku->idkategori == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $buku->judul) }}"
                           class="form-control"
                           required>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text"
                           name="pengarang"
                           value="{{ old('pengarang', $buku->pengarang) }}"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-gradient-warning">
                    <i class="mdi mdi-content-save"></i> Update
                </button>

                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection