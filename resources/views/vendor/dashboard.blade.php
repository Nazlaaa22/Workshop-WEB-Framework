@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Dashboard Vendor</h3>

    <p>Halo, {{ auth()->user()->name }}</p>

    <div class="row">

    <!-- TOTAL MENU -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <h4 class="font-weight-normal">Total Menu</h4>
                <h2 class="mb-0">{{ $totalMenu ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- PESANAN LUNAS -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <h4 class="font-weight-normal">Pesanan Lunas</h4>
                <h2 class="mb-0">{{ $pesananLunas ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- AKSI CEPAT -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <h4 class="font-weight-normal">Kelola Menu</h4>
                <a href="/menu" class="btn btn-light mt-2">Masuk</a>
            </div>
        </div>
    </div>

</div>
</div>

@endsection