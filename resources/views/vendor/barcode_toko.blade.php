<!DOCTYPE html>
<html>
<head>
    <title>Barcode Toko</title>

    <style>

        body{
            margin:0;
            padding:0;
            font-family: Arial, Helvetica, sans-serif;
            background:#f4f4f4;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }

        .barcode-card{
            background:white;
            width:550px;
            padding:40px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
            text-align:center;
        }

        .title{
            font-size:38px;
            font-weight:bold;
            color:#6c4cff;
            margin-bottom:10px;
        }

        .subtitle{
            font-size:20px;
            color:#777;
            margin-bottom:35px;
        }

        .barcode-code{
            font-size:34px;
            font-weight:bold;
            color:#222;
            letter-spacing:4px;
            margin-bottom:30px;
        }

        .barcode-box{
            background:#fafafa;
            border:2px dashed #ddd;
            border-radius:15px;
            padding:35px 20px;
            display:flex;
            justify-content:center;
            align-items:center;
            overflow:hidden;
        }

        .barcode-box div{
            display:flex;
            justify-content:center;
            width:100%;
        }

        .footer{
            margin-top:25px;
            font-size:16px;
            color:#666;
        }

        .btn-print{
            margin-top:30px;
            background:linear-gradient(45deg,#a259ff,#6c4cff);
            border:none;
            color:white;
            padding:14px 35px;
            border-radius:12px;
            font-size:18px;
            cursor:pointer;
            font-weight:bold;
        }

        @media print {

            body{
                background:white;
                min-height:auto;
                display:block;
            }

            .barcode-card{
                width:100%;
                max-width:700px;
                margin:auto;
                box-shadow:none;
                border:none;
                padding-top:80px;
            }

            .btn-print{
                display:none;
            }

            .barcode-box{
                border:none;
                background:white;
            }

        }

    </style>
</head>

<body>

    <div class="barcode-card">

        <div class="title">
            {{ $toko->nama_toko }}
        </div>

        <div class="subtitle">
            Barcode Lokasi Toko
        </div>

        <div class="barcode-code">
            {{ $toko->barcode }}
        </div>

        <div class="barcode-box">

            <div>
                {!! QrCode::size(280)->generate(url('/kunjungan-toko/'.$toko->barcode)) !!}
            </div>

        </div>

        <div class="footer">
            Scan barcode ini untuk validasi kunjungan toko
        </div>

        <button class="btn-print" onclick="window.print()">
            🖨 Cetak Barcode
        </button>

    </div>

</body>
</html>