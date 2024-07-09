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
    <style>
        @font-face {
            font-family: 'BalooDa';
            src: url(../fonts/BalooDa-Regular.ttf);
        }

        @font-face {
            font-family: 'Magmawave';
            src: url(../fonts/MagmaWaveCaps.otf);
        }

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            background-color: #d9d9d9;
        }

        .banner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-size: 19px;
            color: #1a1a1a;
            font-family: 'Roboto';
        }

        .banner-login {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0px 20px 20px 0px;
            background-color: #ffa552;
            width: 449px;
            height: 800px;
        }

        img.icon-ti {
            position: relative;
            width: 200px;
            height: 200px;
            margin-top: 10px;
        }

        h1.title-1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            margin-bottom: 20px;
            margin-left: 60px;
        }

        h1.title-2 {
            font-family: 'Magmawave';
            font-size: 64px;
            margin-top: 20px;
        }

        h1.title-3 {
            font-family: 'BalooDa';
            font-size: 24px;
            margin-top: -20px;
            align-items: center;
            justify-content: center;
        }

        h1.title-4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-login {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px 0px 0px 20px;
            background-color: #fff;
            width: 449px;
            height: 800px;
            padding: 40px;
        }

        p.title-register {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
        }

        a.title-register {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
            text-decoration: none;
            color: #ffa552;

        }

        p.title-forget {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
        }

        a.title-forget {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
            text-decoration: none;
            color: #ffa552;

        }

        .btn-login {
            font-family: 'Roboto';
            font-weight: 700;
            background: #fff;
            color: #ffa552 !important;
            font-size: 22px;
            padding: 8px 20px;
            border-radius: 15px;
            border: 2px solid #ffa552;
            text-decoration: none;
        }

        .btn-login:hover {
            background: #ffa552;
            color: #fff !important;
        }
    </style>
</head>

<body>
    <form method="POST" action="/validation">
        @csrf
        <div class="banner">
            <div class="form-login">
                <div class="col p-6">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif(session()->has('Failed'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('Failed') }}
                        </div>
                    @endif
                    <div class="row-lg-8">
                        <div class="mb-3">
                            <input type="hidden" name="token" id="token" value="{{ $token }}">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmation Password</label>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row-lg-2 text-end mt-2">
                        <div class="text-center">
                            <button type="submit" class="btn-login my-1">Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-login">
                <div class="col p-6">
                    <div class="row-lg-4 text-center">
                        <h1 class="title-2">SIIBALA</h1>
                        <h1 class="title-3">TEKNOLOGI INFORMASI</h1>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
