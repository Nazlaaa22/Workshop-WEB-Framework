<!DOCTYPE html>
<html>
<head>
    <title>Tambah Customer (BLOB)</title>

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

    <h2>Tambah Customer (BLOB)</h2>

    <form method="POST" action="/admin/customer/store1">
        @csrf

        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="provinsi" placeholder="Provinsi" required>
        <input type="text" name="kota" placeholder="Kota" required>
        <input type="text" name="kecamatan" placeholder="Kecamatan" required>
        <input type="text" name="kelurahan" placeholder="Kelurahan" required>
        <input type="text" name="kodepos" placeholder="Kodepos" required>

        <div class="row">
            <div class="foto-box">
                <img id="preview" width="100%" />
            </div>

            <div>
                <button type="button" class="btn" onclick="openCamera()">Ambil Foto</button>
                <br><br>
                <button type="submit" class="btn" onclick="return validateForm()">Simpan Data</button>
            </div>
        </div>

        <input type="hidden" name="foto" id="foto">

    </form>
</div>

<!-- MODAL CAMERA -->
<div class="modal" id="cameraModal">
    <h4>Ambil Foto</h4>

    <video id="video" width="250" autoplay></video>
    <br><br>

    <button class="btn" onclick="capture()">Ambil & Simpan Foto</button>
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
        })
        .catch(err => {
            alert("Kamera tidak bisa diakses!");
        });
    }

    function capture() {
        let canvas = document.getElementById('canvas');
        let video = document.getElementById('video');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        canvas.getContext('2d').drawImage(video, 0, 0);

        let image = canvas.toDataURL('image/png');

        // simpan ke input hidden
        document.getElementById('foto').value = image;

        // tampilkan preview
        document.getElementById('preview').src = image;

        // matikan kamera
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        // tutup modal
        document.getElementById('cameraModal').style.display = 'none';

        alert("Foto berhasil diambil!");
    }

    function validateForm() {
        let foto = document.getElementById('foto').value;

        if (!foto) {
            alert("Ambil foto dulu!");
            return false;
        }

        return true;
    }
</script>

</body>
</html>