<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Papan Antrian</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>

        <body style="
            background:#f4f1f8;
            overflow:hidden;
        ">

        <div class="container-fluid">

            {{-- JUDUL --}}
            <div class="text-center pt-4 mb-5">
                <h1 style="
                    font-size:65px;
                    font-weight:bold;
                    color:#9b51e0;
                ">
                    MEDIFLOW RS
                </h1>

                <p style="
                    font-size:28px;
                    color:gray;
                ">
                    Sistem Antrian Realtime
                </p>
            </div>

            {{-- LOKET --}}
            <div class="row justify-content-center">
                @php

                    $lokets = [
                        1 => 'Poli Umum',
                        2 => 'Poli Gigi',
                        3 => 'Poli Anak',
                        4 => 'Poli Jantung',
                        5 => 'Poli Kandungan',
                    ];

                @endphp

                @foreach($lokets as $nomor => $poli)

                <div class="col-md-2">
                    <div class="card shadow-lg text-center p-4 mb-4"
                        style="
                            border-radius:25px;
                            min-height:500px;
                        "
                    >
                        {{-- NOMOR LOKET --}}
                        <div style="
                            width:90px;
                            height:90px;
                            background:#9b51e0;
                            color:white;
                            border-radius:100px;
                            margin:auto;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:45px;
                            font-weight:bold;
                        ">
                            {{ $nomor }}

                        </div>

                        {{-- NAMA LOKET --}}
                        <h2 class="mt-4 font-weight-bold">
                            Loket {{ $nomor }}
                        </h2>

                        <h4 class="text-muted">
                            {{ $poli }}
                        </h4>

                        {{-- ANTRIAN DIPANGGIL --}}
                        <h1 
                            id="loket{{ $nomor }}"
                            style="
                                font-size:55px;
                                color:#9b51e0;
                                margin-top:30px;
                                font-weight:bold;
                                min-height:80px;
                            "
                        >
                            -
                        </h1>

                        <p style="
                            color:gray;
                            margin-top:10px;
                            font-size:20px;
                        ">
                            Sedang Dipanggil
                        </p>

                        <hr>

                        {{-- ANTRIAN BERIKUTNYA --}}
                        <p style="
                            color:#666;
                            margin-top:10px;
                            font-size:20px;
                        ">
                            Antrian Berikutnya
                        </p>

                        <h2 
                            id="next{{ $nomor }}"
                            style="
                                color:#333;
                                font-size:40px;
                                font-weight:bold;
                            "
                        >
                            -
                        </h2>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- AUDIO --}}
        <audio id="tingtong">
            <source src="/sound/tingtong.mp3" type="audio/mpeg">
        </audio>

        <script>
            let sudahKlik = false;
            document.body.addEventListener('click', function(){

                sudahKlik = true;

            });

            let lastData = {
                loket1: '-',
                loket2: '-',
                loket3: '-',
                loket4: '-',
                loket5: '-',
            };

            let sedangBersuara = false;

            function realtimePapan(){
                ('/sse/antrian')
                .then(res => res.fetchjson())
                .then(data => {
                    for(let i = 1; i <= 5; i++){
                        const current = data['loket' + i];
                        const old = lastData['loket' + i];

                        // UPDATE NOMOR
                        document.getElementById('loket' + i).innerText = current;

                        // UPDATE NEXT
                        document.getElementById('next' + i).innerText = data['next' + i];

                        // SUARA
                        if(
                            current !== old &&
                            current !== '-' &&
                            sudahKlik &&
                            !sedangBersuara &&
                            data.antrians.find(
                                a => a.kode_antrian === current && a.status === 'dipanggil'
                            )
                        ){
                            sedangBersuara = true;
                            const audio = document.getElementById('tingtong');
                            audio.pause();
                            audio.currentTime = 0;
                            window.speechSynthesis.cancel();

                            let poli = '';

                            if(i == 1){
                                poli = 'Poli Umum';
                            }

                            else if(i == 2){
                                poli = 'Poli Gigi';
                            }

                            else if(i == 3){
                                poli = 'Poli Anak';
                            }

                            else if(i == 4){
                                poli = 'Poli Jantung';
                            }

                            else if(i == 5){
                                poli = 'Poli Kandungan';
                            }

                            // PLAY TINGTONG
                            audio.play();

                            // SETELAH TINGTONG
                            setTimeout(() => {

                                const suara = new SpeechSynthesisUtterance(

                                    'Pasien nomor ' + current +

                                    ', silahkan menuju loket ' + i +

                                    ', yaitu ' + poli

                                );

                                suara.lang = 'id-ID';
                                suara.rate = 0.6;
                                suara.pitch = 1.3;
                                suara.volume = 1;
                                speechSynthesis.speak(suara);
                                suara.onend = function(){
                                    sedangBersuara = false;
                                };

                            }, 2500);

                        }
                        lastData['loket' + i] = current;
                    }
                });
            }

            // LOAD
            realtimePapan();

            // REALTIME
            setInterval(realtimePapan, 1000);

        </script>

        <script>
            // LOAD PERTAMA
            realtimePapan();

            // REALTIME
            setInterval(realtimePapan, 1000);
        </script>

    </body>
</html>