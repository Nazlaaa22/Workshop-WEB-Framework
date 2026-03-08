@extends('layouts.app')

@section('style')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-container .select2-selection--single{
    height: 38px;
    padding: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 28px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
    height: 36px;
    }

    .select2-container{
    width:100% !important;
    }
</style>

@endsection


@section('content')

<div class="page-header">
    <h3 class="page-title">Select Kota</h3>
</div>


<div class="card">
<div class="card-body">

<div class="form-group">
<label>Kota</label>
<input type="text" id="inputKota" class="form-control">
</div>

<button class="btn btn-success mt-3" id="btnTambah">
Tambahkan
</button>


<div class="form-group mt-4">
<label>Select Kota</label>

<select id="selectKota" class="form-control">
<option value="">-- Pilih Kota --</option>
</select>

</div>


<h5 class="mt-3">
Kota Terpilih :
<span id="hasilKota"></span>
</h5>

</div>
</div>



<div class="card mt-4">
<div class="card-body">

<h4>Select 2</h4>

<div class="form-group">
<label>Select Kota</label>

<select id="selectKota2" class="form-control">
<option value="">-- Pilih Kota --</option>
</select>

</div>

</div>
</div>


@endsection



@section('script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function(){

// aktifkan select2
$("#selectKota2").select2();


// tombol tambahkan kota
$("#btnTambah").click(function(){

let kota = $("#inputKota").val();

if(kota == ""){
alert("Kota tidak boleh kosong");
return;
}

let option = `<option value="${kota}">${kota}</option>`;

// tambah ke select biasa
$("#selectKota").append(option);

// tambah ke select2
$("#selectKota2").append(option);

$("#inputKota").val("");

});


// ketika kota dipilih
$("#selectKota").change(function(){

let kota = $(this).val();

$("#hasilKota").text(kota);

});

});

</script>

@endsection