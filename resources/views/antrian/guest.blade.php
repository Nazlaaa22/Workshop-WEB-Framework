<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>MediFlow - Pendaftaran Pasien</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{

            background:
            linear-gradient(
                135deg,
                #4c1d95,
                #6d28d9,
                #7c3aed
            );

            min-height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

            overflow:hidden;
        }

        .card-antrian{

            width:100%;
            max-width:500px;

            padding:38px;

            border-radius:28px;

            background:
            rgba(255,255,255,0.12);

            backdrop-filter:blur(18px);

            border:
            1px solid rgba(255,255,255,0.15);

            box-shadow:
            0 8px 32px rgba(0,0,0,0.2);

            color:white;

            animation:fadeIn 0.5s ease;
        }

        .logo-title{

            text-align:center;

            margin-bottom:35px;
        }

        .logo-title h1{

            font-size:52px;

            font-weight:900;

            margin-bottom:8px;

            letter-spacing:1px;

            color:white;
        }

        .logo-title p{

            color:#ede9fe;

            font-size:17px;
        }

        .icon-box{

            width:85px;
            height:85px;

            border-radius:50%;

            background:
            rgba(255,255,255,0.12);

            display:flex;

            justify-content:center;

            align-items:center;

            margin:auto;

            margin-bottom:18px;

            font-size:36px;
        }

        .form-label{

            font-weight:600;

            margin-bottom:10px;

            color:white;
        }

        .form-control,
        .form-select{

            height:54px;

            border-radius:14px;

            border:none;

            background:
            rgba(255,255,255,0.14);

            color:white;

            font-size:16px;
        }

        .form-control::placeholder{

            color:#ede9fe;
        }

        .form-control:focus,
        .form-select:focus{

            background:
            rgba(255,255,255,0.18);

            color:white;

            box-shadow:none;

            border:
            1px solid #d8b4fe;
        }

        .form-select option{

            color:black;
        }

        .btn-daftar{

            width:100%;

            border:none;

            border-radius:14px;

            padding:14px;

            font-size:19px;

            font-weight:700;

            margin-top:10px;

            background:
            linear-gradient(
                90deg,
                #c084fc,
                #8b5cf6
            );

            transition:0.3s;
        }

        .btn-daftar:hover{

            transform:translateY(-2px);

            background:
            linear-gradient(
                90deg,
                #a855f7,
                #7c3aed
            );
        }

        @keyframes fadeIn{

            from{

                opacity:0;

                transform:translateY(20px);
            }

            to{

                opacity:1;

                transform:translateY(0);
            }
        }

    </style>

</head>

<body>

    <div class="card-antrian">

        <div class="logo-title">

            <div class="icon-box">
                🏥
            </div>

            <h1>MediFlow</h1>

            <p>Smart Hospital Queue System</p>

        </div>

        <form action="/guest/store"
              method="POST">

            @csrf

            <div class="mb-4">

                <label class="form-label">
                    Nama Pasien
                </label>

                <input type="text"
                       name="nama_pasien"
                       class="form-control"
                       placeholder="Masukkan nama pasien"
                       required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Pilih Poli
                </label>

                <select name="poli"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Poli --
                    </option>

                    <option value="Poli Umum">
                        Poli Umum
                    </option>

                    <option value="Poli Gigi">
                        Poli Gigi
                    </option>

                    <option value="Poli Anak">
                        Poli Anak
                    </option>

                    <option value="Poli Jantung">
                        Poli Jantung
                    </option>

                    <option value="Poli Kandungan">
                        Poli Kandungan
                    </option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-daftar">

                Ambil Nomor Antrian

            </button>

        </form>

    </div>

</body>
</html>