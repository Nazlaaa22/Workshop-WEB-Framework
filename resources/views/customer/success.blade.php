<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Berhasil</title>
</head>
<body style="text-align:center; margin-top:50px;">

    <h2>Pembayaran Berhasil ✅</h2>

    <p>ID Pesanan: {{ $pesanan->idpesanan }}</p>

    <h4>QR Code:</h4>

    {!! QrCode::size(200)->generate('http://192.168.0.110:8000/pesanan/'.$pesanan->idpesanan) !!}

    <br><br>

    <a href="/customer">Kembali ke Menu</a>

</body>
</html>