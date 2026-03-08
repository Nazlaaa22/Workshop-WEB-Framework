@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        Edit Kategori
    </h3>
    <nav arial-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current= "page">
                <span></span>Kategori <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
            <li class="breadcrumb-item active" aria-current= "page">
                <span></span>Edit Kategori <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<div class="card">
    <div class="card-body">

        <form id="formKategoriEdit" action="{{ route('kategori.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       value="{{ $data->nama_kategori }}"
                       required>
            </div>

            <button type="button" id="btnUpdate" class="btn btn-primary mt-3">
                Update
            </button>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-secondary mt-3">
               Kembali
            </a>

        </form>

    </div>
</div>

@endsection

@section('script')

<script>
$(document).ready(function(){

    $("#btnUpdate").click(function(){

        let form = document.getElementById("formKategoriEdit");

        if(!form.checkValidity()){
            form.reportValidity();
            return;
        }

        $("#btnUpdate").html(
            '<span class="spinner-border spinner-border-sm"></span> Loading...'
        );

        form.submit();

    });

});
</script>

@endsection