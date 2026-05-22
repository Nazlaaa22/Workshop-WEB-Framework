<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor Antrian Berhasil</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{

            background:linear-gradient(135deg,#4c1d95,#7c3aed,#a855f7);

            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            padding:20px;
        }

        .success-card{

            width:100%;
            max-width:430px;

            background:white;

            border-radius:24px;

            padding:22px;

            box-shadow:0 15px 40px rgba(0,0,0,0.15);

            text-align:center;

            margin:auto;
        }

        .check-icon{

            width:75px;
            height:75px;

            background:#ede9fe;

            color:#7c3aed;

            border-radius:50%;

            display:flex;
            justify-content:center;
            align-items:center;

            margin:auto;
            margin-bottom:18px;

            font-size:34px;
            font-weight:bold;
        }

        .title{

            font-size:30px;
            font-weight:800;

            color:#5b21b6;

            margin-bottom:8px;

            line-height:1.2;
        }

        .subtitle{

            color:#6b7280;

            margin-bottom:30px;

            font-size:16px;
        }

        .ticket-box{

            border:3px dashed #c084fc;

            border-radius:24px;

            padding:25px;

            margin-bottom:25px;
        }

        .ticket-label{

            font-size:13px;

            letter-spacing:3px;

            color:#7c3aed;

            font-weight:700;

            margin-bottom:15px;
        }

        .ticket-number{

            font-size:72px;
            font-weight:800;

            color:#6d28d9;

            line-height:1;

            margin-bottom:20px;
        }

        .detail{

            display:flex;
            justify-content:space-between;

            margin-bottom:14px;

            font-size:16px;
        }

        .detail span:first-child{
            color:#6b7280;
        }

        .detail span:last-child{
            font-weight:600;
        }

        .info{

            font-size:15px;
            color:#6b7280;

            margin-bottom:30px;

            line-height:1.6;
        }

        .button-group{

            display:flex;
            gap:15px;
        }

        .btn{

            flex:1;

            padding:15px;

            border:none;

            border-radius:15px;

            font-weight:600;

            font-size:15px;

            text-decoration:none;

            cursor:pointer;

            transition:0.3s;
        }

        .btn-print{

            background:#7c3aed;
            color:white;
        }

        .btn-print:hover{

            background:#6d28d9;
        }

        .btn-back{

            background:#ede9fe;
            color:#6d28d9;
        }

        .btn-back:hover{

            background:#ddd6fe;
        }

        @media print{

            html,body{

                width:100%;
                height:100%;

                background:white !important;
            }

            body{

                margin:0 !important;
                padding:0 !important;

                display:flex;
                justify-content:center;
                align-items:center;
            }

            .success-card{

                width:420px !important;

                transform:scale(0.88);

                transform-origin:center;

                box-shadow:none !important;

                border:2px solid #e5e7eb;

                page-break-inside:avoid;

                margin:auto;
            }

            .button-group{
                display:none !important;
            }

            @page{
                size:A4 portrait;
                margin:0;
            }
        }

    </style>
</head>

<body>

    <div class="success-card">

        <div class="check-icon">
            ✓
        </div>

        <div class="title">
            Pendaftaran Berhasil
        </div>

        <div class="subtitle">
            Silakan menunggu nomor antrian dipanggil
        </div>

        <div class="ticket-box">

            <div class="ticket-label">
                NOMOR ANTRIAN ANDA
            </div>

            <div class="ticket-number">
                {{ $antrian->kode_antrian }}
            </div>

            <div class="detail">
                <span>Nama Pasien</span>
                <span>{{ $antrian->nama_pasien }}</span>
            </div>

            <div class="detail">
                <span>Poli</span>
                <span>{{ $antrian->poli }}</span>
            </div>

            <div class="detail">
                <span>Waktu Daftar</span>
                <span>{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }}</span>
            </div>

        </div>

        <div class="info">
            Harap menunggu hingga nomor Anda dipanggil melalui papan antrian.
        </div>

        <div class="button-group">

            <button onclick="window.print()" class="btn btn-print">
                Cetak
            </button>

            <a href="/guest" class="btn btn-back">
                Daftar Lagi
            </a>

        </div>

    </div>

</body>
</html>