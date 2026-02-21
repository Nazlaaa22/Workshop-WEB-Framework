<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #c471f5, #fa71cd);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .otp-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            width: 400px;
        }

        .otp-input {
            font-size: 24px;
            text-align: center;
            letter-spacing: 10px;
            height: 60px;
        }

        .btn-purple {
            background: linear-gradient(90deg, #c471f5, #fa71cd);
            border: none;
            color: white;
            font-weight: bold;
        }

        .btn-purple:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="otp-card">
    <h3 class="mb-3">Verifikasi OTP</h3>
    <p class="text-muted">Masukkan 6 digit kode yang dikirim ke email kamu</p>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/verify-otp') }}">
        @csrf

        <div class="form-group mb-3">
            <input type="text"
                   name="otp"
                   maxlength="6"
                   class="form-control otp-input"
                   placeholder="______"
                   required>
        </div>

        <button type="submit" class="btn btn-purple btn-block w-100">
            Verifikasi
        </button>
    </form>
</div>

</body>
</html>