<header class="navbar navbar-expand-md d-print-none navbar-pertama">
    <div class="container-xl p-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-icon">
            <a href="/">
                <img class="ti-icon" src="{{ asset('img/logo-SIIBALA.png') }}" alt="">
                <div class="vertical-divider d-block"></div>
                <div class="navbar-title">
                    <h2>SIIBALA</h2>
                    <p>Teknologi Informasi</p>
                </div>
            </a>
        </div>
        @cannot('isAdministrator')
            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                    </a>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                            aria-label="Show notifications">
                            <!-- Icon bell -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                            </svg>
                            <!-- Badge for notification count -->
                            @if ($notifications->count() != 0)
                                <span class="badge bg-red"></span>
                            @endif

                        </a>
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card p-0">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Notifikasi</h3>
                                </div>
                                <div class="card-body">
                                    @if ($notifications->isNotEmpty())
                                        <div class="list-group list-group-flush list-group-hoverable">
                                            @foreach ($notifications as $index => $notifikasi)
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col text-truncate">
                                                            <a href="#" class="text-body d-block" data-toggle="modal"
                                                                data-target="#exampleModal{{ $index }}"><b>{{ $notifikasi->judul }}</b></a>
                                                            <p>{{ $notifikasi->notifikasi }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="list-group list-group-flush list-group-hoverable">
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col text-truncate">
                                                        <p>Tidak Ada Notifikasi</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer">
                                    <!-- Pagination Links -->
                                    {{ $notifications->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modals for notifications -->
                    @foreach ($notifications as $index => $notifikasi)
                        <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel{{ $index }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{ $index }}">
                                            {{ $notifikasi->judul }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $notifikasi->notifikasi }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endcannot



            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    @if (Auth::user()->profile_photo != '-')
                        <img class="avatar avatar-sm" src="/storage/{{ Auth::user()->profile_photo }}">
                    @else
                        <img class="avatar avatar-sm" src="/storage/defaultfoto.png">
                    @endif
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->username }}</div>
                        <div class="mt-1 small text-muted">{{ Auth::user()->role }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">


                    <a href="#" class="dropdown-item" id="showProfileModal">Lihat Profile</a>
                    <a href="/editprofile" class="dropdown-item">Pengaturan</a>
                    @cannot('isAdministrator')
                        <a href="/laporkanmasalah/create" class="dropdown-item">FeedBack</a>
                    @endcannot
                    <form action="/logout" method="post" id="logout-form">
                        @csrf
                        <a class="dropdown-item" href=""
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="profileModal" tabindex="-1" role="dialog"
                aria-labelledby="profileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                @if (Auth::user()->profile_photo != '-')
                                    <img src="/storage/{{ Auth::user()->profile_photo }}"
                                        class="rounded-circle avatar-lg" style="max-width: 300px;"
                                        alt="Profile Picture">
                                @else
                                    <img src="/storage/defaultfoto.png" class="rounded-circle avatar-lg"
                                        style="max-width: 300px;" alt="Default Profile Picture">
                                @endif
                            </div>
                            <div class="mt-3">
                                <p class="mb-1"><strong>Username:</strong> {{ Auth::user()->username }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <!-- Tambahkan detail lainnya sesuai kebutuhan -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
<header class="navbar-expand-md navbar-kedua container-xl">
    <div class="collapse navbar-collapse p-3" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    @can('isAdministrator')
                        <li class="nav-item {{ Request::is('administrator') ? 'active' : '' }}">
                            <a class="nav-link" href="/administrator">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Home
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('isAdmin')
                        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                            <a class="nav-link" href="/">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ Request::is('admin/barang', 'admin/baranghp', 'admin/barangpinjam', 'admin/barangrusak', 'admin/kategoribarang', 'admin/jenisbarang', 'admin/satuan', 'admin/penempatan', 'admin/pemindahaninventaris') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/barang">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <line x1="12" y1="8" x2="12" y2="16" />
                                        <line x1="8" y1="12" x2="16" y2="12" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Barang
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/berita', 'admin/kategoriberita') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/berita">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-news">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M19 4h-14a2 2 0 0 0 -2 2v12c0 1.1 .9 2 2 2h14a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                                        <line x1="10" y1="11" x2="14" y2="11" />
                                        <line x1="12" y1="9" x2="12" y2="13" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Berita
                                </span>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ Request::is('admin/barangmasuk', 'admin/barangkeluar', 'admin/mutasibarang', 'admin/transaksi', 'admin/barangsedangdipinjam', 'admin/pengajuan') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/transaksi">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-transfer">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M20 10h-16l5.5 -6" />
                                        <path d="M4 14h16l-5.5 6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Aktivitas Barang
                                </span>
                            </a>
                        </li>
                        <li
                            class="nav-item dropdown {{ Request::is('admin/mahasiswa', 'admin/dosen', 'admin/staff', 'admin/user', 'admin/prodi', 'admin/bagian', 'admin/ruangan') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Data Master
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/admin/mahasiswa">
                                            Mahasiswa
                                        </a>
                                        <a class="dropdown-item" href="/admin/dosen">
                                            Dosen
                                        </a>
                                        <a class="dropdown-item" href="/admin/staff">
                                            Staff
                                        </a>
                                        <a class="dropdown-item" href="/admin/user">
                                            User
                                        </a>
                                        <a class="dropdown-item" href="/admin/prodi">
                                            Program Studi
                                        </a>
                                        <a class="dropdown-item" href="/admin/bagian">
                                            Bagian Kerja
                                        </a>
                                        <a class="dropdown-item" href="/admin/ruangan">
                                            Ruangan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li
                            class="nav-item dropdown {{ Request::is('admin/user/import', 'admin/dosen/import', 'admin/mahasiswa/import', 'admin/staff/import', 'admin/ruangan/import', 'admin/penempatan/import') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-transfer-in">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 18v3h16v-14l-8 -4l-8 4v3" />
                                        <path d="M4 14h9" />
                                        <path d="M10 11l3 3l-3 3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Import
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/admin/dosen/import">
                                            Dosen
                                        </a>
                                        <a class="dropdown-item" href="/admin/user/import">
                                            User
                                        </a>
                                        <a class="dropdown-item" href="/admin/mahasiswa/import">
                                            Mahasiswa
                                        </a>
                                        <a class="dropdown-item" href="/admin/staff/import">
                                            Staff
                                        </a>
                                        <a class="dropdown-item" href="/admin/ruangan/import">
                                            Ruangan
                                        </a>
                                        <a class="dropdown-item" href="/admin/penempatan/import">
                                            Penempatan Barang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li
                            class="nav-item dropdown {{ Request::is('admin/eksporuser', 'admin/ekspordosen', 'admin/ekspormahasiswa', 'admin/eksporstaff', 'admin/eksporbarang', 'admin/eksporbaranghp', 'admin/eksporbarangkeluar', 'admin/eksportransaksi') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-transfer-out">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 19v2h16v-14l-8 -4l-8 4v2" />
                                        <path d="M13 14h-9" />
                                        <path d="M7 11l-3 3l3 3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Export
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="/admin/eksporuser">
                                            User
                                        </a>
                                        <a class="dropdown-item" href="/admin/ekspordosen">
                                            Dosen
                                        </a>
                                        <a class="dropdown-item" href="/admin/ekspormahasiswa">
                                            Mahasiswa
                                        </a>
                                        <a class="dropdown-item" href="/admin/eksporstaff">
                                            Staff
                                        </a>
                                        <a class="dropdown-item" href="/admin/eksporbarang">
                                            Barang
                                        </a>
                                        <a class="dropdown-item" href="/admin/eksporbaranghp">
                                            Barang Habis Pakai
                                        </a>
                                        <a class="dropdown-item" href="/admin/eksporbarangkeluar">
                                            Barang Keluar
                                        </a>
                                        <a class="dropdown-item" href="/admin/eksportransaksi">
                                            Peminjaman dan Pengembalian
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('isPimpinan')
                        <li class="nav-item {{ Request::is('adminpimpinan') ? 'active' : '' }}">
                            <a class="nav-link" href="/">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/barangmasuk') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/barangmasuk">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-inbox"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <path d="M4 13h3l3 3h4l3 -3h3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Barang Masuk
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/barangkeluar') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/barangkeluar">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="4" width="18" height="4" rx="2" />
                                        <path d="M7 8v4a1 1 0 0 0 1 1h8a1 1 0 0 0 1 -1v-4" />
                                        <line x1="12" y1="16" x2="12" y2="21" />
                                        <line x1="4" y1="13" x2="20" y2="13" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Barang Keluar
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/barang') ? 'active' : '' }}">
                            <a class="nav-link" href="/admin/barang">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Barang
                                </span>
                            </a>
                        </li>
                        <li
                        class="nav-item {{ Request::is('admin/transaksi') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/transaksi">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-transfer">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M20 10h-16l5.5 -6" />
                                    <path d="M4 14h16l-5.5 6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Peminjaman Atau Pengembalian
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('isUser')
                        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                            <a class="nav-link" href="./">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('barang') ? 'active' : '' }}">
                            <a class="nav-link" href="/barang">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <line x1="12" y1="8" x2="12" y2="16" />
                                        <line x1="8" y1="12" x2="16" y2="12" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Inventaris Barang
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('pengajuanpeminjaman') ? 'active' : '' }}">
                            <a class="nav-link" href="/pengajuanpeminjaman">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 15c.667 -1 2 -2 4 -2c1.333 0 2.333 .333 3 1l1 1.5c.333 .5 .667 1.5 1 3h8" />
                                        <line x1="8" y1="13" x2="10" y2="13" />
                                        <line x1="8" y1="17" x2="10" y2="17" />
                                        <line x1="14" y1="13" x2="16" y2="13" />
                                        <line x1="14" y1="17" x2="16" y2="17" />
                                        <line x1="5" y1="20" x2="19" y2="20" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Pengajuan Peminjaman
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('sedangdipinjam') ? 'active' : '' }}">
                            <a class="nav-link" href="/sedangdipinjam">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="7" width="18" height="13" rx="2" />
                                        <polyline points="8 10 12 14 16 10" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Sedang Dipinjam
                                </span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('riwayatpeminjaman') ? 'active' : '' }}">
                            <a class="nav-link" href="/riwayatpeminjaman">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <line x1="8" y1="7" x2="8" y2="7.01" />
                                        <line x1="8" y1="11" x2="8" y2="11.01" />
                                        <line x1="8" y1="15" x2="8" y2="15.01" />
                                        <line x1="12" y1="7" x2="12" y2="7.01" />
                                        <line x1="12" y1="11" x2="12" y2="11.01" />
                                        <line x1="12" y1="15" x2="12" y2="15.01" />
                                        <line x1="16" y1="7" x2="16" y2="7.01" />
                                        <line x1="16" y1="11" x2="16" y2="11.01" />
                                        <line x1="16" y1="15" x2="16" y2="15.01" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Riwayat Peminjaman
                                </span>
                            </a>
                        </li>
                    @endcan
                </ul>

                {{-- Search Bar --}}
                @can('!isAdministrator')
                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                        <form action="/carimenu" method="post" autocomplete="off" novalidate>
                            @csrf
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                                <input type="text" value="" name="search-input" class="form-control"
                                    placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</header>
