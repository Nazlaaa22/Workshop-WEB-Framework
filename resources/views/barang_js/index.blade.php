@extends('layouts.app')

@section('style')
<style>
#tableBarang tbody tr:hover{
cursor:pointer;
}
</style>
@endsection

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Barang JS</h3>
</div>

<div class="card">
<div class="card-body">

<h4>Tambah Barang</h4>

<form id="formBarang">

<div class="form-group">
<label>Nama Barang</label>
<input type="text" id="namaBarang" class="form-control" required>
</div>

<div class="form-group mt-3">
<label>Harga Barang</label>
<input type="number" id="hargaBarang" class="form-control" required>
</div>

<button type="button" id="btnSubmit" class="btn btn-success mt-3">
Submit
</button>

</form>

</div>
</div>

<div class="card mt-4">
<div class="card-body">

<h4>Daftar Barang</h4>

<table class="table table-bordered" id="tableBarang">

<thead>
<tr>
<th>ID Barang</th>
<th>Nama</th>
<th>Harga</th>
</tr>
</thead>

<tbody>
</tbody>

</table>

</div>
</div>

<!-- Modal Edit Delete -->
<div class="modal fade" id="modalBarang" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Barang</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="form-group mb-3">
<label>ID Barang</label>
<input type="text" id="editId" class="form-control" readonly>
</div>

<div class="form-group mb-3">
<label>Nama Barang</label>
<input type="text" id="editNama" class="form-control" required>
</div>

<div class="form-group mb-3">
<label>Harga Barang</label>
<input type="number" id="editHarga" class="form-control" required>
</div>

</div>

<div class="modal-footer">

<button class="btn btn-danger" id="btnHapus">
Hapus
</button>

<button class="btn btn-success" id="btnUbah">
Ubah
</button>

</div>

</div>
</div>
</div>

@endsection

@section('script')

<script>

$(document).ready(function(){

let nomor = 1;
let selectedRow;

// TAMBAH DATA
$("#btnSubmit").click(function(){

let form = document.getElementById("formBarang");

if(!form.checkValidity()){
    form.reportValidity();
    return;
}

let nama = $("#namaBarang").val();
let harga = $("#hargaBarang").val();

let id = "BRG" + String(nomor).padStart(3,'0');

let row = `
<tr>
<td>${id}</td>
<td>${nama}</td>
<td>${harga}</td>
</tr>
`;

$("#tableBarang tbody").append(row);

nomor++;

$("#namaBarang").val("");
$("#hargaBarang").val("");

});

// KLIK ROW → MODAL
$('#tableBarang tbody').on('click','tr',function(){

selectedRow = $(this);

let id = $(this).find("td:eq(0)").text();
let nama = $(this).find("td:eq(1)").text();
let harga = $(this).find("td:eq(2)").text();

$("#editId").val(id);
$("#editNama").val(nama);
$("#editHarga").val(harga);

let modal = new bootstrap.Modal(document.getElementById('modalBarang'));
modal.show();

});

// UBAH DATA
$("#btnUbah").click(function(){

let id = $("#editId").val();
let nama = $("#editNama").val();
let harga = $("#editHarga").val();

selectedRow.find("td:eq(0)").text(id);
selectedRow.find("td:eq(1)").text(nama);
selectedRow.find("td:eq(2)").text(harga);

$('#modalBarang').modal('hide');

});

// HAPUS DATA
$("#btnHapus").click(function(){

selectedRow.remove();

$('#modalBarang').modal('hide');

});

});

</script>

@endsection