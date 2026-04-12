<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
</head>
<body style="margin:40px; font-family:sans-serif;">

    <h2>Detail Pesanan 🧾</h2>

    <p><b>ID:</b> {{ $pesanan->idpesanan }}</p>
    <p><b>Nama:</b> {{ $pesanan->nama }}</p>

    <hr>

    <h4>Daftar Menu:</h4>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>

        @foreach($detail as $d)
        <tr>
            <td>{{ $d->idmenu }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>{{ $d->harga }}</td>
            <td>{{ $d->subtotal }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Total: Rp {{ number_format($pesanan->total) }}</h3>

</body>
</html>