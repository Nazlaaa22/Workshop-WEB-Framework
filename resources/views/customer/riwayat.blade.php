<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Saya</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

<div class="container mt-5">
    <h3>Riwayat Pesanan 🧾</h3>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $p)
            <tr>
                <td>{{ $p->nama }}</td>
                <td>Rp {{ number_format($p->total) }}</td>
                <td>
                    @if($p->status_bayar == 1)
                        <span class="badge bg-success">Lunas</span>
                    @else
                        <span class="badge bg-warning">Belum</span>
                    @endif
                </td>
                <td>
                    <a href="/nota/{{ $p->idpesanan }}" class="btn btn-sm btn-primary">
                        Download Nota
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>