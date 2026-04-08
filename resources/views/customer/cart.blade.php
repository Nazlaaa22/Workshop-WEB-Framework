<!DOCTYPE html>
<html>
    <head>
        <title>Keranjang</title>

        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <style>
            body {
                background: #f5f6fa;
            }

            .cart-title {
                text-align: center;
                margin-bottom: 30px;
            }

            .cart-card {
                display: flex;
                align-items: center;
                background: white;
                padding: 15px;
                border-radius: 12px;
                margin-bottom: 15px;
            }

            .cart-img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 10px;
                margin-right: 15px;
            }

            .cart-info {
                flex: 1;
            }

            .btn-purple {
                background: linear-gradient(45deg, #a259ff, #6a5cff);
                border: none;
                color: white;
            }

            .total-box {
                background: white;
                padding: 20px;
                border-radius: 12px;
                margin-top: 20px;
            }
        </style>
    </head>

    <body>

        <div class="container mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Keranjang 🛒</h2>

                <form action="/cart/clear" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        Kosongkan
                    </button>
                </form>
            </div>

            @php $total = 0; @endphp

            @forelse($cart as $id => $item)
            <div class="card mb-3 p-3 d-flex flex-row align-items-center">

                <img src="{{ asset('storage/' . $item['gambar']) }}"
                    style="width:80px; height:80px; object-fit:cover; border-radius:10px;">

                <div class="ms-3 flex-grow-1">
                    <h5>{{ $item['nama'] }}</h5>
                    <p class="mb-1">Jumlah: {{ $item['jumlah'] }}</p>
                    <p class="mb-0 text-muted">
                        Rp {{ number_format($item['harga'] * $item['jumlah']) }}
                    </p>
                </div>

                <!-- HAPUS -->
                <form action="/cart/remove/{{ $id }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>

            </div>

            @php $total += $item['harga'] * $item['jumlah']; @endphp

            @empty
                <p class="text-center">Keranjang kosong 😢</p>
            @endforelse

            <!-- TOTAL -->
            <div class="card p-3 text-center">
                <h4>Total: Rp {{ number_format($total) }}</h4>

                <form action="/checkout" method="POST">
                    @csrf
                    <button class="btn btn-primary mt-2">
                        Bayar Sekarang 💳
                    </button>
                </form>
            </div>

        </div>

    </body>
</html>