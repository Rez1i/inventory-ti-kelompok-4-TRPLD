<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIBALA-TI</title>

    <!-- Google Font + Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" crossorigin="anonymous">
    </script>
    <!-- Trix Editor -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- Custom Styles CSS -->
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">

    <style>
        .background-img {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .background-img::before {
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

        .btn-banner {
            font-family: 'BalooDa';
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(30px);
            color: #1a1a1a !important;
            font-size: 22px;
            padding: 8px 20px;
            border-radius: 16px;
            border: 3px solid #fff;
            margin-top: 100px;
            margin-right: 20px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .btn-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            background: #ffa552;
            z-index: -1;
            transition: transform 0.3s ease;
            transform: scaleX(0);
            transform-origin: left;
        }

        .btn-banner:hover {
            color: #1a1a1a !important;
            border-color: #1a1a1a;
        }

        .btn-banner:hover::before {
            transform: scaleX(1);
        }
    </style>

</head>

<body>
    <!-- Header -->
    @include('user.layouts.navbar')


    <!-- Main -->
    @yield('main')

    <!-- Footer -->
    @include('user.layouts.footer')

    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- JS navbar-->
    <script src="js/navbar.js"></script>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    <!-- Script-Section -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#news-slider").owlCarousel({
                items: 3,
                navigation: true,
                navigationText: ["", ""],
                autoPlay: true
            });
            $("#news-slider-terbaru").owlCarousel({
                items: 1,
                navigation: true,
                navigationText: ["", ""],
                autoPlay: true
            });
        });
    </script>
</body>

</html>
