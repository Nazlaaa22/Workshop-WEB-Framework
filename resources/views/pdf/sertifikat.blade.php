<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            text-align: center;
            font-family: Georgia, serif;
        }

        .container {
            border: 12px solid #6a1b9a;
            padding: 60px;
        }

        h1 {
            font-size: 50px;
            letter-spacing: 5px;
            color: #6a1b9a;
        }

        .nama {
            font-size: 40px;
            font-weight: bold;
            margin: 30px 0;
        }

        h2 {
            font-size: 28px;
        }

        .footer {
            margin-top: 80px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>SERTIFIKAT</h1>

    <p>Diberikan kepada:</p>

    <div class="nama">{{ $nama }}</div>

    <p>Atas partisipasinya sebagai:</p>

    <h2>{{ $jabatan }}</h2>

    <div class="footer">
        <p>Universitas Airlangga</p>
        <p>{{ $tanggal }}</p>
    </div>
</div>

</body>
</html>