@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Pesanan Lunas</h3>

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Total</th>
            <th>Status</th>
        </tr>

        @foreach($pesanan as $p)
        <tr>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->total }}</td>
            <td>
                <span class="badge bg-success">Lunas</span>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection