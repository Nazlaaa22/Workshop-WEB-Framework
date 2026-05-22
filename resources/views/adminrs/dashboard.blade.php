@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <div>
            <h3 class="page-title">Dashboard Admin RS</h3>
            <p class="text-muted">
                Sistem Antrian Rumah Sakit Realtime
            </p>
        </div>

        <h4>Halo, {{ auth()->user()->name }}</h4>
    </div>

    {{-- CARD --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h4>Menunggu</h4>
                    <h1 id="menunggu">0</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                    <h4>Dipanggil</h4>
                    <h1 id="dipanggil">0</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <h4>Terlambat</h4>
                    <h1 id="terlambat">0</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <h4>Selesai</h4>
                    <h1 id="selesai">0</h1>
                </div>
            </div>
        </div>

    </div>

    {{-- LOKET PELAYANAN --}}
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="mb-4">Loket Pelayanan</h3>
            <style>
                .row{
                    justify-content: space-between;
                }
            </style>

            <div class="row">
                @php
                    $lokets = [
                        1 => 'Poli Umum',
                        2 => 'Poli Gigi',
                        3 => 'Poli Anak',
                        4 => 'Poli Jantung',
                        5 => 'Poli Kandungan',
                    ];
                @endphp

                @foreach($lokets as $nomorLoket => $poli)

                @php
                    $dipanggil = \App\Models\Antrian::where('status', 'dipanggil')
                        ->where('poli', $poli)
                        ->latest()
                        ->first();
                    $menunggu = \App\Models\Antrian::where('status', 'menunggu')
                        ->where('poli', $poli)
                        ->first();
                @endphp

                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card shadow text-center p-3 mx-auto"
                        style="
                            border-radius:20px;
                            min-height:200px;
                            width:170px;
                        "
                >
                    <div style="
                        width:50px;
                        height:50px;
                        background:#9b51e0;
                        color:white;
                        border-radius:100px;
                        margin:auto;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:28px;
                        font-weight:bold;
                    ">
                        {{ $nomorLoket }}
                    </div>

                    <h5 class="mt-3 font-weight-bold">
                        Loket {{ $nomorLoket }}
                    </h5>

                    <small class="text-muted">
                        {{ $poli }}
                    </small>

                    <h2 
                        id="loket{{ $nomorLoket }}"
                        class="text-primary font-weight-bold mt-3 mb-3"
                        style="
                            font-size:50px;
                            min-height:70px;
                        "
                    >
                        {{ $dipanggil->kode_antrian ?? '-' }}
                    </h2>

                    @if($menunggu)

                    <form 
                        action="/panggil/{{ $menunggu->id }}/{{ $nomorLoket }}"
                        method="POST"
                    >
                        @csrf

                        <button class="btn btn-primary btn-sm px-4">
                            Panggil
                        </button>
                    </form>

                    @else

                    <button class="btn btn-secondary btn-sm px-4" disabled>
                        Kosong
                    </button>

                    @endif
                </div>
            </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- DATA PASIEN --}}
    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">Data Antrian Pasien</h3>
             <a href="/reset-antrian" class="btn btn-danger btn-sm">Reset Antrian</a>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-dark text-white">

                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Pasien</th>
                            <th>Poli</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody id="tbody-antrian">
                        @foreach($antrians as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_antrian }}</td>
                            <td>{{ $item->nama_pasien }}</td>
                            <td>{{ $item->poli }}</td>

                            <td>
                                @if($item->status == 'menunggu')
                                    <span class="badge badge-primary">
                                        Menunggu
                                    </span>
                                @elseif($item->status == 'dipanggil')
                                    <span class="badge badge-warning">
                                        Dipanggil
                                    </span>
                                @elseif($item->status == 'terlambat')
                                    <span class="badge badge-danger">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-1">
                                    {{-- DIPANGGIL --}}
                                    <form action="/status/{{ $item->id }}/dipanggil" method="POST">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">🔊</button>
                                    </form>
                                    {{-- SELESAI --}}
                                    <form action="/status/{{ $item->id }}/selesai" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm">✔</button>
                                    </form>
                                    {{-- TERLAMBAT --}}
                                    <form action="/status/{{ $item->id }}/terlambat" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">⏰</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

setInterval(async function(){
    const response = await fetch('/sse/antrian');
    const data = await response.json();
    let html = '';
    data.antrians.forEach((item, index) => {
        html += `
        <tr>
            <td>${index + 1}</td>
            <td>${item.kode_antrian}</td>
            <td>${item.nama_pasien}</td>
            <td>${item.poli}</td>
            <td>
                ${
                    item.status == 'menunggu'
                    ? '<span class="badge badge-primary">Menunggu</span>'
                    : item.status == 'dipanggil'
                    ? '<span class="badge badge-warning">Dipanggil</span>'
                    : item.status == 'terlambat'
                    ? '<span class="badge badge-danger">Terlambat</span>'
                    : '<span class="badge badge-success">Selesai</span>'
                }
            </td>

            <td>
                <div class="d-flex gap-1">
                    <form action="/status/${item.id}/dipanggil" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-warning btn-sm">🔊</button>
                    </form>

                    <form action="/status/${item.id}/selesai" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-success btn-sm">✔</button>
                    </form>

                    <form action="/status/${item.id}/terlambat" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-danger btn-sm">⏰</button>
                    </form>
                </div>
            </td>
        </tr>
        `;
    });

    document.getElementById('tbody-antrian').innerHTML = html;

}, 1000);

</script>

<script>

function realtimeAntrian(){

    fetch('/sse/antrian')
    .then(res => res.json())
    .then(data => {

        // CARD
        document.getElementById('menunggu').innerText = data.menunggu;
        document.getElementById('dipanggil').innerText = data.dipanggil;
        document.getElementById('terlambat').innerText = data.terlambat;
        document.getElementById('selesai').innerText = data.selesai;

        // LOKET
        document.getElementById('loket1').innerText = data.loket1;
        document.getElementById('loket2').innerText = data.loket2;
        document.getElementById('loket3').innerText = data.loket3;
        document.getElementById('loket4').innerText = data.loket4;
        document.getElementById('loket5').innerText = data.loket5;

    });

}

// LOAD PERTAMA
realtimeAntrian();

// REALTIME 1 DETIK
setInterval(realtimeAntrian, 1000);

</script>

@endsection