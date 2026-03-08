@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
#tableBarang tbody tr:hover{
    cursor:pointer;
}
</style>
@endsection


@section('content')

<div class="page-header">
    <h3 class="page-title">Data Barang JS (Datatables)</h3>
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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function(){

let nomor = 1;

let table = $('#tableBarang').DataTable();

let selectedRow;

// SUBMIT TAMBAH DATA
$("#btnSubmit").click(function(){

let form = document.getElementById("formBarang");

if(!form.checkValidity()){
    form.reportValidity();
    return;
}

let nama = $("#namaBarang").val();
let harga = $("#hargaBarang").val();

let id = "BRG" + String(nomor).padStart(3,'0');

table.row.add([
    id,
    nama,
    harga
]).draw();

nomor++;

$("#namaBarang").val("");
$("#hargaBarang").val("");

});

// KLIK ROW → BUKA MODAL
$('#tableBarang tbody').on('click', 'tr', function () {

selectedRow = table.row(this);

let data = selectedRow.data();

$("#editId").val(data[0]);
$("#editNama").val(data[1]);
$("#editHarga").val(data[2]);

let modal = new bootstrap.Modal(document.getElementById('modalBarang'));
modal.show();

});

// TOMBOL UBAH
$("#btnUbah").click(function(){

let id = $("#editId").val();
let nama = $("#editNama").val();
let harga = $("#editHarga").val();

selectedRow.data([
    id,
    nama,
    harga
]).draw();

$('#modalBarang').modal('hide');

});

// TOMBOL HAPUS
$("#btnHapus").click(function(){

selectedRow.remove().draw();

$('#modalBarang').modal('hide');

});


});

</script>

@endsection