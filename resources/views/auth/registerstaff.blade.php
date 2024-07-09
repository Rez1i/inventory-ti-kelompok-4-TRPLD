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
    <form method="POST" action="/registerstaff">
        @csrf
        <div class="banner">
            <div class="form-login">
                <div class="col p-6">
                    <div class="row-lg-2">
                        <h1 class="title-4">Staff</h1>
                    </div>
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
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bagian_id" class="form-label">Bagian</label>
                            <br>
                            <select name="bagian_id" class="form-select text-secondary" required>
                                <option value="">Pilih Bagian</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bagian }}</option>
                                @endforeach
                            </select>
                            @error('bagian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telfon</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                id="no_telp" name="no_telp" required>
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
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
                            <button type="submit" class="btn-login my-1">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-login">
                <div class="col p-6">
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
    </form>
    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
