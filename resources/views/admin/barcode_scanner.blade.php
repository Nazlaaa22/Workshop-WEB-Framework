@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title"> Scan Barcode </h3>
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">

                    <h4 class="card-title mb-4">Scanner Kamera</h4>

                    <!-- VIDEO -->
                    <video id="reader" class="w-100 rounded border"></video>

                    <br><br>

                    <!-- BUTTON -->
                    <button class="btn btn-primary" onclick="startScanner()">Start Scan</button>

                    <hr>

                    <!-- TAMBAHAN: SCAN GAMBAR -->
                    <h5 class="mt-3">Atau Upload Gambar</h5>

                    <input type="file" id="fileInput" class="form-control mt-2">

                    <br>

                    <button class="btn btn-success" onclick="scanFile()">Scan dari Gambar</button>

                </div>
            </div>
        </div>

        <!-- HASIL -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Hasil Scan</h4>

                    <div id="result" class="alert alert-info text-center">
                        Belum ada hasil scan
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- SOUND -->
<audio id="beep" src="{{ asset('sound/beep.mp3') }}"></audio>

<!-- ZXING -->
<script src="https://unpkg.com/@zxing/library@latest"></script>

<script>
let codeReader;

// AUDIO
document.body.addEventListener('click', function () {
    const beep = document.getElementById("beep");
    beep.play().then(() => {
        beep.pause();
        beep.currentTime = 0;
    }).catch(() => {});
}, { once: true });

function playBeep(){
    const beep = document.getElementById("beep");

    beep.pause(); 
    beep.currentTime = 0;

    const playPromise = beep.play();

    if (playPromise !== undefined) {
        playPromise.catch(() => {
            console.log("Audio masih diblok browser");
        });
    }
}

function tampilkanData(data){
    if(data){
        document.getElementById('result').innerHTML = `
            <div class="alert alert-success">
                <h5><b>${data.nama_barang}</b></h5>
                <p>ID: ${data.id_barang}</p>
                <p>Harga: Rp ${data.harga}</p>
            </div>
        `;
    } else {
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">
                Data tidak ditemukan
            </div>
        `;
    }
}

function startScanner() {
    codeReader = new ZXing.BrowserMultiFormatReader();
    codeReader.listVideoInputDevices().then((videoInputDevices) => {
        const selectedDeviceId = videoInputDevices[videoInputDevices.length - 1].deviceId;
        codeReader.decodeFromVideoDevice(selectedDeviceId, 'reader', (result, err) => {
            if (result) {
                playBeep(); 

                codeReader.reset(); 
                fetch('/admin/barcode/get/' + result.text)
                .then(res => res.json())
                .then(data => tampilkanData(data))
                .catch(() => {
                    document.getElementById('result').innerHTML = `
                        <div class="alert alert-danger">
                            Gagal mengambil data
                        </div>
                    `;
                });

            }
        });
    });
}

// SCAN DARI GAMBAR
function scanFile() {
    const fileInput = document.getElementById('fileInput');

    if (fileInput.files.length === 0) {
        alert("Pilih gambar dulu!");
        return;
    }

    const reader = new ZXing.BrowserMultiFormatReader();

    reader.decodeFromImage(undefined, URL.createObjectURL(fileInput.files[0]))
    .then(result => {

        playBeep();

        fetch('/admin/barcode/get/' + result.text)
        .then(res => res.json())
        .then(data => tampilkanData(data))
        .catch(() => {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">
                    Gagal mengambil data
                </div>
            `;
        });

    })
    .catch(err => {
        alert("Barcode tidak terbaca dari gambar!");
    });
}
</script>

@endsection