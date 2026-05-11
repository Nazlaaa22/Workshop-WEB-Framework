@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">Kunjungan Toko</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <!-- LIST TOKO -->
            <h4 class="mb-3">List Toko</h4>

            @php
                $last = \App\Models\LokasiToko::orderBy('barcode', 'desc')->first();

                if($last){
                    $num = (int) substr($last->barcode, 3) + 1;
                } else {
                    $num = 1;
                }

                $barcodeBaru = 'TOK' . str_pad($num, 3, '0', STR_PAD_LEFT);
            @endphp

            <!-- FORM TAMBAH TOKO -->
            <form action="/kunjungan-toko/store" method="POST" class="mb-4">
                @csrf

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Barcode</label>

                            <input type="text"
                                name="barcode"
                                class="form-control"
                                value="{{ $barcodeBaru }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Toko</label>

                            <input type="text"
                                name="nama_toko"
                                class="form-control"
                                required>
                        </div>
                    </div>

                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Barcode</th>
                        <th>Nama Toko</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Accuracy</th>
                        <th>Cetak Barcode</th>
                    </tr>

                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->barcode }}</td>
                        <td>{{ $d->nama_toko }}</td>
                        <td>{{ $d->latitude }}</td>
                        <td>{{ $d->longitude }}</td>
                        <td>{{ $d->accuracy }}</td>

                        <td>
                            <a href="/barcode-toko/{{ $d->barcode }}"
                               target="_blank"
                               class="btn btn-sm btn-primary">
                               Cetak
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <hr class="my-5">

                <!-- INPUT TITIK AWAL -->
                <h4 class="mb-4">Input Titik Awal</h4>

                <div class="form-group">
                    <label>Latitude</label>

                    <input type="text"
                        name="latitude"
                        id="latitude"
                        class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label>Longitude</label>

                    <input type="text"
                        name="longitude"
                        id="longitude"
                        class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label>Accuracy</label>

                    <input type="text"
                        name="accuracy"
                        id="accuracy"
                        class="form-control"
                        required>
                </div>

                <div class="mt-4">

                    <button type="button"
                        class="btn btn-info"
                        onclick="getLocation()">
                        Geoloc
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<script>

async function getLocation() {

    try {

        const position = await getAccuratePosition(50);

        document.getElementById('latitude').value =
            position.coords.latitude;

        document.getElementById('longitude').value =
            position.coords.longitude;

        document.getElementById('accuracy').value =
            position.coords.accuracy;

    } catch(error) {

        alert("Gagal mengambil lokasi");

    }

}

function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {

    return new Promise((resolve, reject) => {

        let bestResult = null;

        const startTime = Date.now();

        const watchId = navigator.geolocation.watchPosition(

            (position) => {

                const acc = position.coords.accuracy;

                // simpan hasil terbaik
                if (
                    !bestResult ||
                    acc < bestResult.coords.accuracy
                ) {
                    bestResult = position;
                }

                // kalau sudah cukup akurat
                if (acc <= targetAccuracy) {

                    navigator.geolocation.clearWatch(watchId);

                    resolve(bestResult);
                }

                // timeout
                if (Date.now() - startTime >= maxWait) {

                    navigator.geolocation.clearWatch(watchId);

                    if(bestResult) {
                        resolve(bestResult);
                    } else {
                        reject("Timeout");
                    }

                }

            },

            (error) => reject(error),

            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: maxWait
            }

        );

    });

}

</script>

@endsection