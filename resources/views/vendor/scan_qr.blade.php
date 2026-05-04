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

<!-- SOUND -->
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

    // 🎯 TAMPILKAN DATA
    function tampilkanData(res){
        if(res.status){
            const data = res.data;
            let menuList = '';
            if(data.items && data.items.length > 0){
                data.items.forEach(item => {
                    menuList += `
                        <tr style="background:transparent;">
                            <td style="text-align:left;">${item.nama_menu}</td>
                            <td>${item.jumlah}</td>
                            <td>Rp ${item.harga}</td>
                        </tr>
                    `;
                });
            }

            document.getElementById('result').innerHTML = `
                <div class="alert alert-success" style="background:rgba(0,0,0,0.05); border:1px solid rgba(0,0,0,0.1);">
                    
                    <h5><b>Pesanan ID: ${data.idpesanan}</b></h5>
                    <hr>
                    <p>Nama: ${data.nama}</p>
                    <p>Total: Rp ${data.total}</p>

                    ${menuList ? `
                    <hr>

                    <div style="overflow-x:auto;">
                        <table class="table mt-2 text-center" 
                            style="width:100%; font-size:14px; background:transparent;">

                            <thead>
                                <tr style="background:rgba(0,0,0,0.05);">
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${menuList}
                            </tbody>

                        </table>
                    </div>
                    ` : ''}

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
                    playBeep();
                    codeReader.reset(); 
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
            playBeep();
            ambilData(result.text);
        })
        .catch(() => {
            alert("QR tidak terbaca!");
        });
    }

    // 🔗 AMBIL DATA
    function ambilData(qrValue){
        let id = qrValue;
        if(qrValue.includes('/')){
            id = qrValue.split('/').pop();
        }
        fetch("{{ url('/vendor/get-pesanan') }}/" + id)
        .then(res => res.json())
        .then(res => tampilkanData(res))
        .catch(err => {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">
                    Gagal mengambil data dari server
                </div>
            `;
        });
    }

</script>

@endsection