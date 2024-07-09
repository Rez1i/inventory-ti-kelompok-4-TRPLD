<header>
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            @auth
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">
                        <div class="nav-item dropdown d-none d-md-flex me-3 ">
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
                                                                <a href="#" class="text-body d-block"
                                                                    data-toggle="modal"
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
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="nav-item dropdown">
                        <!-- jika nav-link dihapus  -->
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar">
                                @if (Auth::user()->profile_photo !='-')
                                <img class="avatar avatar-sm rounded-circle" src="/storage/{{ Auth::user()->profile_photo }}">
                                @else
                                <img class="avatar avatar-sm rounded-circle" src="/storage/defaultfoto.png">
                                @endif
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div style=" font-size: 24px; width:auto">
                                    {{ Str::limit(Auth::user()->username, 10) }}</div>
                                <div class="mt-1 small"
                                    style="font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px;">
                                    {{ Auth::user()->role }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="/editprofile" class="dropdown-item">Profile</a>
                            <a href="/laporkanmasalah/create" class="dropdown-item">Laporkan Masalah</a>
                            <div class="dropdown-divider"></div>
                            <form action="/logout" method="post" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="navbar-nav flex-row order-md-last">
                    <a class="login-button" href="/login">Login</a>
                </div>
            @endauth
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link {{ Request::is('adminuser') ? 'active' : '' }}" aria-current="page"
                            href="/">Beranda</a>
                    </li>
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link {{ Request::is('berita') ? 'active' : '' }}" href="/berita">Berita</a>
                    </li>
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link {{ Request::is('barang') ? 'active' : '' }}" href="/barang">Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</header>
