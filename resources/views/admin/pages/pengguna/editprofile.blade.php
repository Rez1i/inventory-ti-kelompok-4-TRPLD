@extends('admin.layouts.template')

@section('main')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <!-- Informasi Profil -->
            <div class="card shadow-sm" style="height: 26rem;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <center>
                        @if (Auth::user()->profile_photo != '-')
                            <img src="/storage/{{ Auth::user()->profile_photo }}" class="rounded-circle avatar-lg mb-3"
                                style="max-width: 180px;" alt="Profile Picture">
                        @else
                            <img src="/storage/defaultfoto.png" class="rounded-circle avatar-lg mb-3"
                                style="max-width: 180px;" alt="Default Profile Picture">
                        @endif
                        <h3>{{ Auth::user()->username }}</h3>
                        <h3 class="card-text text-muted">{{ Auth::user()->email }}</h3>
                    </center>
                </div>
            </div>
        </div>


        <div class="col-lg-8">
            <!-- Card untuk menu mengubah profil -->
            <div class="card shadow-sm " style="height:26rem;">
                <div class="card-header">
                    <h3 class="mb-0">Ubah Profil</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="/ubahusername" class="text-decoration-none">
                                <i class="fas fa-user me-2"></i> Ubah Username
                            </a>
                            <p class="text-muted mb-0">Ubah username Anda untuk mencerminkan identitas Anda atau
                                memperbarui
                                informasi yang relevan.</p>
                        </li>
                        <li class="list-group-item">
                            <a href="/ubahemail" class="text-decoration-none">
                                <i class="fas fa-envelope me-2"></i> Ubah Email
                            </a>
                            <p class="text-muted mb-0">Ganti alamat email Anda untuk menerima komunikasi penting atau
                                memperbarui informasi kontak Anda.</p>
                        </li>
                        <li class="list-group-item">
                            <a href="/ubahpassword" class="text-decoration-none">
                                <i class="fas fa-lock me-2"></i> Ubah Password
                            </a>
                            <p class="text-muted mb-0">Pastikan keamanan akun Anda dengan mengubah password secara
                                berkala
                                dan menggunakan kombinasi karakter yang kuat.</p>
                        </li>
                        <li class="list-group-item">
                            <a href="/ubahfotoprofile" class="text-decoration-none">
                                <i class="fas fa-image me-2"></i> Ubah Foto Profil
                            </a>
                            <p class="text-muted mb-0">Perbarui foto profil Anda untuk memberikan gambaran yang lebih
                                akurat
                                tentang diri Anda kepada pengguna lainnya.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
