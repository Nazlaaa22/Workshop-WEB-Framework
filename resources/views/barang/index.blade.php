@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                Data Barang UMKM
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('barang.print') }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Pilih</th>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($barang as $b)
                            <tr>
                                <td>
                                    <input type="checkbox"
                                           name="barang_ids[]"
                                           value="{{ $b->id_barang }}">
                                </td>

                                <td>{{ $b->id_barang }}</td>
                                <td>{{ $b->nama_barang }}</td>

                                <td>
                                    Rp {{ number_format($b->harga,0,',','.') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="row mt-4">

                    <div class="col-md-3">
                        <label>X (Kolom)</label>
                        <input type="number"
                               name="start_x"
                               class="form-control"
                               min="1" max="5"
                               required>
                    </div>

                    <div class="col-md-3">
                        <label>Y (Baris)</label>
                        <input type="number"
                               name="start_y"
                               class="form-control"
                               min="1" max="8"
                               required>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary">
                            Cetak Label
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection