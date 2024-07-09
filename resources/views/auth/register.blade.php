<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIBALA-TI : Register</title>

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
            background-image: url('assets/gambarpoli/IMG-20240701-WA0007.jpg');
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
                <div class="row-lg-2 text-center">
                    <h1 class="title-4">Silakan pilih jenis akun yang ingin Anda buat:</h1>
                </div>
                <div class="row-lg-6">
                    <div class="btn-mahasiswa text-center mb-3">
                        <a href="/registermahasiswa" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-backpack2" viewBox="0 0 20 20">
                                <path
                                    d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14" />
                                <path fill-rule="evenodd"
                                    d="M4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10z" />
                                <path
                                    d="M6 2.341V2a2 2 0 1 1 4 0v.341c2.33.824 4 3.047 4 5.659v1.191l1.17.585a1.5 1.5 0 0 1 .83 1.342V13.5a1.5 1.5 0 0 1-1.5 1.5h-1c-.456.607-1.182 1-2 1h-7a2.5 2.5 0 0 1-2-1h-1A1.5 1.5 0 0 1 0 13.5v-2.382a1.5 1.5 0 0 1 .83-1.342L2 9.191V8a6 6 0 0 1 4-5.659M7 2v.083a6 6 0 0 1 2 0V2a1 1 0 0 0-2 0M3 13.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8A5 5 0 0 0 3 8zm-1-3.19-.724.362a.5.5 0 0 0-.276.447V13.5a.5.5 0 0 0 .5.5H2zm12 0V14h.5a.5.5 0 0 0 .5-.5v-2.382a.5.5 0 0 0-.276-.447L14 10.309Z" />
                            </svg>Mahasiswa
                        </a>
                    </div>
                    <div class="btn-dosen text-center mb-3">
                        <a href="/registerdosen" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" class="bi bi-person-video3"
                                viewBox="0 0 20 20">
                                <path
                                    d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2" />
                                <path
                                    d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z" />
                            </svg>Dosen
                        </a>
                    </div>
                    <div class="btn-staff text-center ">
                        <a href="/registerstaff" class="btn btn-warning text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-briefcase-fill" viewBox="0 0 20 20">
                                <path
                                    d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5" />
                                <path
                                    d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85z" />
                            </svg>Staff
                        </a>
                    </div>
                </div>
                <div class="row-lg-4 text-center mt-2">
                    <p class="title-register">Sudah punya akun? <a class="title-register" href="/login">Login
                            Disini.</a></p>
                </div>
            </div>
        </div>
        <div class="banner-login">
            <div class="col p-6 ">
                <div class="row-lg-4">
                    <h1 class="title-1">Selamat Datang</h1>
                </div>
                <div class="row-lg-4  text-center">
                    <img class="icon-ti" alt="" src="img/Logo TI.png">
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
