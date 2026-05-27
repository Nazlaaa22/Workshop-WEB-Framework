<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Absensi NFC</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body style="
    background: white;
    min-height:100vh;
">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-lg border-0"
                style="
                    border-radius:25px;
                    overflow:hidden;
                "
            >

                {{-- HEADER --}}
                <div style="
                    background:#9b51e0;
                    padding:35px;
                    text-align:center;
                    color:white;
                ">

                    <i class="fas fa-id-card"
                        style="
                            font-size:70px;
                            margin-bottom:20px;
                        ">
                    </i>

                    <h1 style="
                        font-weight:bold;
                    ">
                        ABSENSI NFC
                    </h1>

                    <p style="
                        opacity:.9;
                        font-size:18px;
                    ">
                        Sistem Presensi Realtime Menggunakan NFC
                    </p>

                </div>

                {{-- BODY --}}
                <div class="card-body p-5 text-center">

                    <button
                        onclick="scanNFC()"
                        class="btn btn-lg btn-primary px-5 py-3"
                        style="
                            border-radius:15px;
                            font-size:22px;
                            background:#9b51e0;
                            border:none;
                        "
                    >

                        <i class="fas fa-wifi mr-2"></i>
                        Aktifkan NFC

                    </button>

                    {{-- HASIL --}}
                    <div class="mt-5">

                        <h4 class="text-muted">
                            Hasil Scan Kartu
                        </h4>

                        <div class="mt-4"
                            style="
                                background:#f4f1f8;
                                border-radius:20px;
                                padding:30px;
                            "
                        >

                            <h1 id="hasil"
                                style="
                                    color:#9b51e0;
                                    font-weight:bold;
                                    font-size:45px;
                                    letter-spacing:2px;
                                "
                            >
                                -
                            </h1>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="mt-4">

                        <div id="status"
                            class="alert alert-secondary"
                            style="
                                border-radius:15px;
                                font-size:18px;
                            "
                        >

                            Menunggu scan kartu...

                        </div>

                    </div>

                    {{-- DAFTAR KARTU --}}
                    <div class="mt-4">

                        <input
                            type="text"
                            id="nama"
                            class="form-control"
                            placeholder="Masukkan Nama Pemilik Kartu"
                            style="
                                border-radius:15px;
                                height:55px;
                                font-size:18px;
                            "
                        >

                        <button
                            onclick="daftarKartu()"
                            class="btn btn-success btn-block mt-3"
                            style="
                                border-radius:15px;
                                height:55px;
                                font-size:18px;
                            "
                        >

                            Daftarkan Kartu NFC

                        </button>

                        <a href="/nfc/riwayat"class="btn w-100 mt-2"
                            style="
                                background:#8e2de2;
                                color:white;
                                border-radius:12px;
                                padding:12px;
                                font-weight:bold;
                            ">
                            Lihat Riwayat
                        </a>

                    </div>

                    {{-- INFO --}}
                    <div class="mt-5 text-left">

                        <div class="card border-0"
                            style="
                                background:#f8f9fa;
                                border-radius:15px;
                            "
                        >

                            <div class="card-body">

                                <h5 class="mb-3">
                                    <i class="fas fa-circle-info text-primary"></i>
                                    Informasi
                                </h5>

                                <ul class="mb-0">

                                    <li>Gunakan Google Chrome Android</li>

                                    <li>Pastikan NFC HP aktif</li>

                                    <li>Dekatkan kartu NFC ke bagian belakang HP</li>

                                    <li>Data scan akan tersimpan otomatis</li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

async function scanNFC(){

    try{

        const ndef = new NDEFReader();

        await ndef.scan();

        document.getElementById('status').className =
            "alert alert-info";

        document.getElementById('status').innerHTML =
            "NFC aktif, silahkan tempel kartu...";

        // SAAT KARTU DITEMPEL
        ndef.addEventListener("reading", async ({ serialNumber }) => {

            // TAMPILKAN SERIAL
            document.getElementById('hasil').innerText =
                serialNumber;

            // CEK KARTU
            const response = await fetch('/nfc/check', {

                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

                body: JSON.stringify({

                    serial_number: serialNumber

                })

            });

            const result = await response.json();

            if(result.success){

                document.getElementById('status').className =
                    "alert alert-success";

                document.getElementById('status').innerHTML =
                    "Absensi berhasil : " + result.nama;

                // SIMPAN RIWAYAT
                await fetch('/nfc/save', {

                    method: 'POST',

                    headers: {

                        'Content-Type': 'application/json',

                        'X-CSRF-TOKEN': '{{ csrf_token() }}'

                    },

                    body: JSON.stringify({

                        serial_number: serialNumber

                    })

                });

            }else{

                document.getElementById('status').className =
                    "alert alert-danger";

                document.getElementById('status').innerHTML =
                    "Kartu belum terdaftar";

            }

        });

    }catch(error){

        console.log(error);

        document.getElementById('status').className =
            "alert alert-danger";

        document.getElementById('status').innerHTML =
            error;

    }

}

async function daftarKartu(){

    let nama =
        document.getElementById('nama').value;

    let serial =
        document.getElementById('hasil').innerText;

    if(serial == "-"){

        alert("Scan kartu dulu!");

        return;
    }

    const response =
        await fetch('/nfc/register', {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'X-CSRF-TOKEN':
                '{{ csrf_token() }}'

        },

        body: JSON.stringify({

            nama: nama,

            serial_number: serial

        })

    });

    const result =
        await response.json();

    alert(result.message);

}
</script>

</body>
</html>