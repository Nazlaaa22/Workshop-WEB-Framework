<!DOCTYPE html>
    <html>
        <head>
            <title>Riwayat NFC</title>
            <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                rel="stylesheet"
            >
        </head>

        <body style="background:#f5f5f5;">

        <div class="container mt-5">
            <div class="card shadow p-4">
                <h2 class="mb-4 text-center">
                    Riwayat Absensi NFC
                </h2>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Serial Number</th>
                            <th>Waktu Scan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->nama }}</td>
                            <td>{{ $log->serial_number }}</td>
                            <td>{{ $log->scan_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>