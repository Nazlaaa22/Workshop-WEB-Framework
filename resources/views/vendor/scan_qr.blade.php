@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title"> Scan QR Pesanan Customer </h3>
    </div>

    <div class="row">

        <!-- SCANNER -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">

                    <h4 class="card-title mb-4">Scanner QR</h4>

                    <!-- VIDEO -->
                    <video id="reader" class="w-100 rounded border"></video>

                    <br><br>

                    <button class="btn btn-gradient-primary" onclick="startScanner()">
                        Start Scan
                    </button>

                    <hr>

                    <!-- Upload alternatif -->
                    <h5 class="mt-3">Atau Upload QR</h5>

                    <input type="file" id="fileInput" class="form-control mt-2">

                    <br>

                    <button class="btn btn-success" onclick="scanFile()">
                        Scan dari Gambar
                    </button>

                </div>
            </div>
        </div>

        <!-- HASIL -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Detail Pesanan</h4>

                    <div id="result" class="alert alert-info text-center">
                        Belum ada hasil scan
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<!-- 🔊 SOUND (PAKAI FILE LOKAL) -->
<audio id="beep" src="{{ asset('sound/beep.mp3') }}"></audio>

<!-- ZXING -->
<script src="https://unpkg.com/@zxing/library@latest"></script>

<script>

let codeReader;

// 🔊 PLAY BEEP
function playBeep(){
    const beep = document.getElementById("beep");
    beep.currentTime = 0;

    const playPromise = beep.play();
    if (playPromise !== undefined) {
        playPromise.catch(() => {});
    }
}

// 🎯 TAMPILKAN DATA (FIX SESUAI RESPONSE API)
function tampilkanData(res){

    if(res.status){

        const data = res.data;

        document.getElementById('result').innerHTML = `
            <div class="alert alert-success">
                <h5><b>Pesanan ID: ${data.idpesanan}</b></h5>
                <hr>
                <p>Nama: ${data.nama}</p>
                <p>Total: Rp ${data.total}</p>
                <hr>
                <b>Status: ${data.status_bayar == 1 ? 'Lunas' : 'Belum Bayar'}</b>
            </div>
        `;

    } else {
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">
                Data pesanan tidak ditemukan
            </div>
        `;
    }
}

// 📷 START CAMERA SCAN
function startScanner(){

    codeReader = new ZXing.BrowserMultiFormatReader();

    codeReader.listVideoInputDevices().then((devices) => {

        const selectedDeviceId = devices[devices.length - 1].deviceId;

        codeReader.decodeFromVideoDevice(selectedDeviceId, 'reader', (result, err) => {

            if(result){

                playBeep(); // 🔊

                codeReader.reset(); // ⛔ stop scan

                ambilData(result.text);

            }

        });

    });
}

// 🖼️ SCAN DARI GAMBAR
function scanFile(){

    const fileInput = document.getElementById('fileInput');

    if(fileInput.files.length === 0){
        alert("Pilih gambar QR dulu!");
        return;
    }

    const reader = new ZXing.BrowserMultiFormatReader();

    reader.decodeFromImage(undefined, URL.createObjectURL(fileInput.files[0]))
    .then(result => {

        playBeep(); // 🔊

        ambilData(result.text);

    })
    .catch(() => {
        alert("QR tidak terbaca!");
    });

}

// 🔗 AMBIL DATA (FIX URL + RESPONSE)
function ambilData(qrValue){

    let id = qrValue;

    // kalau QR berisi URL → ambil ID terakhir
    if(qrValue.includes('/')){
        id = qrValue.split('/').pop();
    }

    console.log("FINAL ID:", id);

    fetch("{{ url('/vendor/get-pesanan') }}/" + id)
    .then(res => res.json())
    .then(res => tampilkanData(res))
    .catch(err => {
        console.log(err);
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">
                Gagal mengambil data dari server
            </div>
        `;
    });
}

</script>

@endsection