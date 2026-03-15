@extends('layouts.app')

@section('title','Wilayah Indonesia')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        Wilayah Indonesia AJAX
    </h3>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Pilih Wilayah</h4>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Provinsi</label>
                <select id="provinsi" class="form-control">
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label>Kota / Kabupaten</label>
                <select id="kota" class="form-control">
                    <option value="">-- Pilih Kota --</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label>Kecamatan</label>
                <select id="kecamatan" class="form-control">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label>Kelurahan</label>
                <select id="kelurahan" class="form-control">
                    <option value="">-- Pilih Kelurahan --</option>
                </select>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<script>

    $(document).ready(function(){

        // ambil data provinsi
        $.get("/wilayah/provinsi", function(data){
            data.forEach(function(item){
                $("#provinsi").append(
                    `<option value="${item.id}">${item.name}</option>`
                );
            });
        });

        // ketika provinsi dipilih
        $("#provinsi").change(function(){
            let id = $(this).val();
            $("#kota").html('<option value="">-- Pilih Kota --</option>');
            $("#kecamatan").html('<option value="">-- Pilih Kecamatan --</option>');
            $("#kelurahan").html('<option value="">-- Pilih Kelurahan --</option>');
            $.get("/wilayah/kota/"+id, function(data){
                data.forEach(function(item){
                    $("#kota").append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
            });
        });

        // ketika kota dipilih
        $("#kota").change(function(){
            let id = $(this).val();
            $("#kecamatan").html('<option value="">-- Pilih Kecamatan --</option>');
            $("#kelurahan").html('<option value="">-- Pilih Kelurahan --</option>');
            $.get("/wilayah/kecamatan/"+id, function(data){
                data.forEach(function(item){
                    $("#kecamatan").append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
            });
        });

        // ketika kecamatan dipilih
        $("#kecamatan").change(function(){
            let id = $(this).val();
            $("#kelurahan").html('<option value="">-- Pilih Kelurahan --</option>');
            $.get("/wilayah/kelurahan/"+id, function(data){
                data.forEach(function(item){
                    $("#kelurahan").append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
            });
        });
    });
</script>

@endsection

