<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Customer</title>
        <style>
            body {
                font-family: Arial;
            }

            .container {
                width: 600px;
                margin: 30px auto;
                border: 2px solid #ccc;
                padding: 20px;
            }

            input {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
                border: 2px solid #9acd32;
            }

            .row {
                display: flex;
                gap: 20px;
            }

            .foto-box {
                width: 150px;
                height: 150px;
                border: 2px solid #9acd32;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn {
                padding: 10px 15px;
                background: #4da6ff;
                border: none;
                color: white;
                cursor: pointer;
            }

            .modal {
                display: none;
                position: fixed;
                top: 20%;
                left: 35%;
                background: white;
                padding: 20px;
                border: 2px solid #333;
            }
        </style>
    </head>

    <body>

    <div class="container">

        <form method="POST" action="/admin/customer/store2">
            @csrf

            <input type="text" name="nama" placeholder="Nama">
            <input type="text" name="alamat" placeholder="Alamat">
            <input type="text" name="provinsi" placeholder="Provinsi">
            <input type="text" name="kota" placeholder="Kota">
            <input type="text" name="kecamatan" placeholder="Kecamatan">
            <input type="text" name="kelurahan" placeholder="Kelurahan">
            <input type="text" name="kodepos" placeholder="Kodepos">

            <div class="row">
                <div class="foto-box">
                    <img id="preview" width="100%" />
                </div>

                <div>
                    <button type="button" class="btn" onclick="openCamera()">Ambil Foto</button>
                    <br><br>
                    <button type="submit" class="btn">Simpan Data</button>
                </div>
            </div>

            <input type="hidden" name="foto" id="foto">

        </form>
    </div>

    <!-- MODAL CAMERA -->
    <div class="modal" id="cameraModal">
        <h4>Modal Ambil Foto</h4>

        <video id="video" width="250" autoplay></video>
        <br><br>

        <button class="btn" onclick="takePhoto()">Snapshot</button>
        <button class="btn" onclick="closeCamera()">Simpan Foto</button>
    </div>

    <canvas id="canvas" style="display:none;"></canvas>

        <script>
            let stream;

            function openCamera() {
                document.getElementById('cameraModal').style.display = 'block';

                navigator.mediaDevices.getUserMedia({ video: true })
                .then(s => {
                    stream = s;
                    document.getElementById('video').srcObject = stream;
                });
            }

            function closeCamera() {
                document.getElementById('cameraModal').style.display = 'none';

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            }

            function takePhoto() {
                let canvas = document.getElementById('canvas');
                let video = document.getElementById('video');

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                canvas.getContext('2d').drawImage(video, 0, 0);

                let image = canvas.toDataURL('image/png');

                document.getElementById('foto').value = image;

                document.getElementById('preview').src = image;
                
                closeCamera();
                alert("Foto berhasil diambil!");
            }
        </script>
    </body>
</html>