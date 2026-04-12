@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="page-title">Data Customer</h3>

        <a href="/admin/customer/create2" class="btn btn-primary btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i>
            Tambah Customer
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Daftar Customer</h4>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">

                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Kodepos</th>
                            <th>Foto</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($customers as $c)
                        <tr>
                            <td>{{ $c->nama }}</td>
                            <td>{{ $c->alamat }}</td>
                            <td>{{ $c->kota }}</td>
                            <td>{{ $c->kecamatan }}</td>
                            <td>{{ $c->kelurahan }}</td>
                            <td>{{ $c->kodepos }}</td>

                            <td>
                                @if($c->foto_blob)
                                    @php
                                        if (is_resource($c->foto_blob)) {
                                            rewind($c->foto_blob); 
                                            $image = stream_get_contents($c->foto_blob);
                                        } else {
                                            $image = $c->foto_blob;
                                        }
                                    @endphp
                                    <img src="data:image/png;base64,{{ base64_encode($image) }}"width="80"class="img-thumbnail"style="border-radius: 10px;">
                                @elseif($c->foto_path)
                                    <img src="{{ asset('storage/' . $c->foto_path) }}" width="80" class="img-thumbnail"style="border-radius: 10px;">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection