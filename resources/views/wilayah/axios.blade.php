@extends('layouts.app')

@section('title','Wilayah Indonesia')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        Wilayah Indonesia AXIOS
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

    document.addEventListener("DOMContentLoaded", function(){

        // load provinsi
        axios.get('/wilayah/provinsi')
        .then(function(response){

            let data = response.data;
            let html = '<option value="">-- Pilih Provinsi --</option>';

            data.forEach(function(item){
                html += `<option value="${item.id}">${item.name}</option>`;
            });

            document.getElementById("provinsi").innerHTML = html;

        });


        // provinsi → kota
        document.getElementById("provinsi").addEventListener("change", function(){

            let id = this.value;

            axios.get('/wilayah/kota/' + id)
            .then(function(response){

                let data = response.data;
                let html = '<option value="">-- Pilih Kota --</option>';

                data.forEach(function(item){
                    html += `<option value="${item.id}">${item.name}</option>`;
                });

                document.getElementById("kota").innerHTML = html;

                document.getElementById("kecamatan").innerHTML =
                '<option value="">-- Pilih Kecamatan --</option>';

                document.getElementById("kelurahan").innerHTML =
                '<option value="">-- Pilih Kelurahan --</option>';

            });

        });


        // kota → kecamatan
        document.getElementById("kota").addEventListener("change", function(){

            let id = this.value;

            axios.get('/wilayah/kecamatan/' + id)
            .then(function(response){

                let data = response.data;
                let html = '<option value="">-- Pilih Kecamatan --</option>';

                data.forEach(function(item){
                    html += `<option value="${item.id}">${item.name}</option>`;
                });

                document.getElementById("kecamatan").innerHTML = html;

            });

        });


        // kecamatan → kelurahan
        document.getElementById("kecamatan").addEventListener("change", function(){

            let id = this.value;

            axios.get('/wilayah/kelurahan/' + id)
            .then(function(response){

                let data = response.data;
                let html = '<option value="">-- Pilih Kelurahan --</option>';

                data.forEach(function(item){
                    html += `<option value="${item.id}">${item.name}</option>`;
                });

                document.getElementById("kelurahan").innerHTML = html;

            });
        });
    });
</script>

@endsection

