<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Berhasil</title>
</head>
<body style="text-align:center; margin-top:50px; font-family:sans-serif;">

    <h2>Pembayaran Berhasil ✅</h2>

    <p>ID Pesanan: {{ $pesanan->idpesanan }}</p>

    <p>
        <b>Status:</b>
        @if($pesanan->status_bayar == 1)
            <span style="color:green;">Lunas</span>
        @else
            <span style="color:red;">Belum Bayar</span>
        @endif
    </p>

    <h4>QR Code:</h4>

    {!! QrCode::size(200)->generate(url('/pesanan/' . $pesanan->idpesanan)) !!}

    <br><br>

    <h3>Detail Pesanan 🧾</h3>

    <table border="1" cellpadding="8" cellspacing="0" style="margin:auto;">
        <tr>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>

        @foreach($detail as $d)
        <tr>
            <td>{{ $d->nama_menu }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>Rp {{ number_format($d->harga) }}</td>
            <td>Rp {{ number_format($d->subtotal) }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Total: Rp {{ number_format($pesanan->total) }}</h3>

    <br>

    <a href="/customer">Kembali ke Menu</a>

</body>
</html>