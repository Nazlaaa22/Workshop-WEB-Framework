@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-3">Data Vendor</h4>

    <a href="/vendor/create" class="btn btn-primary mb-3">Tambah Vendor</a>

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>

        @foreach($vendors as $v)
        <tr>
            <td>{{ $v->name }}</td>
            <td>{{ $v->email }}</td>
            <td>
                <a href="/vendor/{{ $v->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                <form action="/vendor/{{ $v->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection