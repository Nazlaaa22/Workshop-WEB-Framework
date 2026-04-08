<!DOCTYPE html>
<html>
<head>
    <title>Menu Customer</title>

    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background: #f5f6fa;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
        }

        .menu-card {
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .menu-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .menu-body {
            padding: 15px;
            text-align: center;
        }

        .btn-purple {
            background: linear-gradient(45deg, #a259ff, #6a5cff);
            border: none;
            color: white;
        }

        .btn-purple:hover {
            opacity: 0.9;
        }

        .qty-box {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .qty-box button {
            width: 30px;
            height: 30px;
        }
    </style>
</head>

<body>

<div class="container mt-4">
    
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="title">
        <h2>Kantin Matcha Holic 🍵</h2>
        <p>Pilih menu favoritmu</p>
    </div>

    <div class="text-end mb-3">
        <a href="/cart" class="btn btn-dark">🛒 Lihat Keranjang</a>
    </div>

    <div class="row">
        @foreach($menu as $m)
        <div class="col-md-3 mb-4">
            <div class="card menu-card">

                <img src="{{ asset('storage/' . $m->path_gambar) }}" class="menu-img">

                <div class="menu-body">
                    <h5>{{ $m->nama_menu }}</h5>
                    <p>Rp {{ number_format($m->harga) }}</p>

                    <!-- BUTTON AWAL -->
                    <button class="btn btn-purple"
                        onclick="showQty({{ $m->idmenu }})"
                        id="btn-{{ $m->idmenu }}">
                        Pesan
                    </button>

                    <!-- QTY CONTROL -->
                    <div id="qty-{{ $m->idmenu }}" style="display:none;">

                        <div class="qty-box">
                            <button type="button" onclick="kurang({{ $m->idmenu }})">-</button>
                            <span id="jumlah-{{ $m->idmenu }}">1</span>
                            <button type="button" onclick="tambah({{ $m->idmenu }})">+</button>
                        </div>

                        <form action="/cart/add" method="POST" style="margin-top:10px;">
                            @csrf
                            <input type="hidden" name="idmenu" value="{{ $m->idmenu }}">
                            <input type="hidden" name="jumlah" id="input-{{ $m->idmenu }}" value="1">

                            <button class="btn btn-warning btn-sm mt-2">
                                Tambah ke Keranjang
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>

<script>
function showQty(id) {
    document.getElementById('btn-' + id).style.display = 'none';
    document.getElementById('qty-' + id).style.display = 'block';
}

function tambah(id) {
    let el = document.getElementById('jumlah-' + id);
    let input = document.getElementById('input-' + id);

    let val = parseInt(el.innerText);
    val++;

    el.innerText = val;
    input.value = val;
}

function kurang(id) {
    let el = document.getElementById('jumlah-' + id);
    let input = document.getElementById('input-' + id);

    let val = parseInt(el.innerText);

    if (val > 1) {
        val--;
        el.innerText = val;
        input.value = val;
    }
}
</script>

</body>
</html>