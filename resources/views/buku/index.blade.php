@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title">
        <i class="mdi mdi-book-open-page-variant text-primary me-2"></i>
        Data Buku
    </h3>

    <a href="{{ route('buku.create') }}" class="btn btn-gradient-primary btn-sm">
        <i class="mdi mdi-plus"></i> Tambah Buku
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card mt-3 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $item->kode }}
                            </span>
                        </td>
                        <td class="fw-semibold">
                            {{ $item->judul }}
                        </td>
                        <td>{{ $item->pengarang }}</td>
                        <td>
                            <span class="badge bg-success">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">

                            <a href="{{ route('buku.edit', $item->id) }}"
                               class="btn btn-sm btn-warning">
                                <i class="mdi mdi-pencil"></i>
                            </a>

                            <form action="{{ route('buku.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus buku ini?')">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="mdi mdi-book-off display-4 d-block mb-2"></i>
                            Belum ada data buku
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection