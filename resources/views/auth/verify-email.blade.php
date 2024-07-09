<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIBALA-TI : Verify Email</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom Styles CSS -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

    <style>
        body {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url('{{ asset('assets/gambarpoli/IMG-20240701-WA0007.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(1.5px);
            /* Tambahkan efek blur */
            z-index: -1;
            /* Pastikan efek blur berada di belakang konten */
        }
    </style>
</head>

<body>
    <div class="banner">
        <div class="form-login">
            <div class="col p-6">
                <h1 class="title-4 text-center">Terima Kasih</h1>
                <div class="text-center m-5">
                    <h5 class="card-title">Mohon Cek Email</h5>
                    <p class="card-text">Validasi sudah terkirim ke email Anda</p>
                    <form action="/email/verification-notification" method="post">
                        @csrf
                        <button type="submit" class="btn-login">Kirim Ulang</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="banner-login">
            <div class="col p-6">
                <div class="row-lg-4  text-center">
                    <img class="icon-ti" alt="" src="{{ asset('img/Logo TI.png') }}">
                </div>
                <div class="row-lg-4 text-center">
                    <h1 class="title-2">SIIBALA</h1>
                    <h1 class="title-3">TEKNOLOGI INFORMASI</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
