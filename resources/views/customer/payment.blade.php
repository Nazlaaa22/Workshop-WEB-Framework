<!DOCTYPE html>
<html>
    <head>
        <title>Pembayaran</title>

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <style>
            body {
                background: #f5f6fa;
            }

            .payment-box {
                max-width: 500px;
                margin: 80px auto;
                background: white;
                padding: 30px;
                border-radius: 12px;
                text-align: center;
            }

            .btn-purple {
                background: linear-gradient(45deg, #a259ff, #6a5cff);
                border: none;
                color: white;
            }
        </style>
    </head>

    <body>

        <div class="payment-box">

            <h3>Pembayaran 💳</h3>

            <p><b>Nama:</b> {{ $pesanan->nama }}</p>
            <p><b>Total:</b> Rp {{ number_format($pesanan->total) }}</p>

            <hr>

            <button id="pay-button" class="btn btn-purple w-100">
                Bayar Sekarang
            </button>

        </div>

        <!-- MIDTRANS SCRIPT -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>

        <script>
            document.getElementById('pay-button').onclick = function () {

            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = '/payment/success/{{ $pesanan->idpesanan }}';
                },
                onPending: function(result){
                    window.location.href = '/payment/success/{{ $pesanan->idpesanan }}';
                },
                onClose: function(){
                    window.location.href = '/payment/success/{{ $pesanan->idpesanan }}';
                }
            });

            };
        </script>
    </body>
</html>