@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            Validasi Kunjungan Toko
        </h3>
    </div>

    <div class="card">
        <div class="card-body text-center">

            <h2 class="mb-3 text-primary">
                {{ $toko->nama_toko }}
            </h2>

            <h4 class="mb-4">
                {{ $toko->barcode }}
            </h4>

            <table class="table table-bordered">

                <tr>
                    <th width="30%">Latitude Toko</th>
                    <td>{{ $toko->latitude }}</td>
                </tr>

                <tr>
                    <th>Longitude Toko</th>
                    <td>{{ $toko->longitude }}</td>
                </tr>

                <tr>
                    <th>Accuracy Toko</th>
                    <td>{{ $toko->accuracy }}</td>
                </tr>

            </table>

            <div class="mt-4">

                <button class="btn btn-info"
                    onclick="ambilLokasi()">

                    Ambil Lokasi Saya

                </button>

            </div>

            <div id="hasil" class="mt-4"></div>

        </div>
    </div>

</div>

<script>

    function haversine(lat1, lon1, lat2, lon2){

        const R = 6371000;

        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;

        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +

            Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) *

            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c;
    }



    function ambilLokasi(){

        navigator.geolocation.getCurrentPosition(function(position){

            let userLat = position.coords.latitude;
            let userLng = position.coords.longitude;
            let userAcc = position.coords.accuracy;

            let tokoLat = {{ $toko->latitude }};
            let tokoLng = {{ $toko->longitude }};
            let tokoAcc = {{ $toko->accuracy }};



            let jarak = haversine(
                tokoLat,
                tokoLng,
                userLat,
                userLng
            );



            let threshold = 300 + tokoAcc + userAcc;



            let status = '';
            let warna = '';



            if(jarak <= threshold){

                status = 'DITERIMA ✅';
                warna = 'success';

            } else {

                status = 'DITOLAK ❌';
                warna = 'danger';

            }



            document.getElementById('hasil').innerHTML = `

                <div class="alert alert-${warna}">

                    <h4>Status: ${status}</h4>

                    <hr>

                    <p>
                        <b>Jarak ke toko:</b>
                        ${jarak.toFixed(2)} meter
                    </p>

                    <p>
                        <b>Threshold:</b>
                        ${threshold.toFixed(2)} meter
                    </p>

                    <p>
                        <b>Latitude User:</b>
                        ${userLat}
                    </p>

                    <p>
                        <b>Longitude User:</b>
                        ${userLng}
                    </p>

                    <p>
                        <b>Accuracy User:</b>
                        ${userAcc}
                    </p>

                </div>

            `;

        });

    }
</script>
@endsection