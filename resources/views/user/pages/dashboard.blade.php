@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section halaman-beranda background-img" id="Beranda">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h1 class="welcome-title mb-2 text-white">
                                Selamat Datang di</h1>
                            <h2 class="welcome-title text-white">Sistem Informasi</h2>
                            <h2 class="welcome-title text-white">Inventaris Barang Labor</h2>
                            <h2 class="welcome-title mb-4 text-white">Di Jurusan Teknologi Informasi</h2>
                            <div class="mt-4">
                                <br>
                                <a href="#tentang-kami" class="btn-banner">Selengkapnya</a>
                                <a href="/barang" class="btn-banner">Ayo Pinjam Barang</a>
                            </div>
                        </div>
                        <div class="slides col-lg-6">
                            <div class="slide slide-1">
                                <img src="{{ asset('img/banner/logo-group.jpg') }}" alt="">
                            </div>
                            <div class="slide slide-2">
                                <img src="img/banner/Gambar-tes1.jpg" alt="">
                            </div>
                            <div class="slide slide-3">
                                <img src="img/banner/Gambar-tes2.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Banner 1 -->
        <section class="page-section" id="tentang-kami">
            <div class="container">
                <h1 class="banner-title text-center">Tentang Kami</h1>

                <!-- Gambar 1 -->
                <div class="banner-about">
                    <div class="image-1">
                        <img src="img/banner/Kemudahan.jpg" alt="">
                    </div>
                    <div class="desc">
                        <h2>Kemudahan Mengelola Inventaris Barang</h2>
                        <p>Maksimalkan efisiensi laboratorium dengan sistem inventaris ini. Pemantauan dan peminjaman
                            barang kini lebih cepat, mudah, dan terorganisir. Dengan antarmuka yang intuitif, Anda dapat
                            memastikan semua kebutuhan laboratorium terpenuhi tanpa kendala. Transformasi proses
                            inventaris laboratorium Jurusan Teknologi Informasi dengan teknologi canggih. Sistem ini
                            memudahkan Anda dalam mengelola peminjaman dan pengembalian barang, memastikan semua barang
                            selalu tersedia saat dibutuhkan.</p>
                    </div>
                </div>

                <!-- Gambar 2 -->
                <div class="banner-about">
                    <div class="desc">
                        <h2>Ayo Pinjam Barang dengan Mudah!</h2>
                        <p>Nikmati kemudahan dalam proses peminjaman barang laboratorium dengan sistem kami yang cepat
                            dan efisien. Sistem ini dirancang untuk menghemat waktu dan tenaga Anda, memastikan setiap
                            kebutuhan inventaris terpenuhi dengan lancar dan tanpa kendala. Dari login yang simpel
                            hingga pengambilan barang yang mulus, kami memastikan setiap langkah dibuat sepraktis
                            mungkin untuk Anda.</p>
                    </div>
                    <div class="image-1">
                        <img src="img/banner/Ayo.jpg" alt="">
                    </div>
                </div>

                <!-- Gambar 3 -->
                <div class="banner-about">
                    <div class="image-1">
                        <img src="img/banner/Keamanan.jpg" alt="">
                    </div>
                    <div class="desc">
                        <h2>Keamanan dan Kepastian Data</h2>
                        <p>Data inventaris Anda akan terlindungi dengan sistem keamanan canggih kami. Sistem ini
                            menawarkan enkripsi data yang kuat, backup otomatis untuk mencegah kehilangan data, serta
                            akses terbatas yang hanya diberikan kepada pengguna yang berwenang. Anda dapat merasa tenang
                            karena informasi Anda berada dalam tangan yang aman.</p>
                    </div>
                </div>

                <!-- Gambar 4 -->
                <div class="banner-about">
                    <div class="desc">
                        <h2>Integrasi Mudah dan Dukungan Lengkap</h2>
                        <p>Integrasikan SIIBALA-TI dengan berbagai sistem lain secara mudah dan nikmati dukungan penuh
                            dari tim kami. Dengan API terbuka dan dukungan untuk berbagai format data, kami memastikan
                            fleksibilitas yang Anda butuhkan. Tim bantuan teknis kami tersedia 24/7 untuk memastikan
                            semua operasional berjalan lancar dan efisien.</p>
                    </div>
                    <div class="image-1">
                        <img src="img/banner/Integrasi.jpg" alt="">
                    </div>
                </div>

            </div>
        </section>

        <!-- Banner-2 -->
        <section class="page-section">
            <div class="container">
                <h1 class="banner-title text-center">Berita Terkini</h1>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="news-slider" class="owl-carousel">

                            <!-- 1 -->
                            @foreach ($beritaterbaru->take(6) as $item)
                                <div class="news-grid">
                                    <div class="news-grid-image"><img src="/storage/{{ $item->gambar }}" alt="">
                                        <div class="news-grid-box">
                                            <h1>{{ Carbon\Carbon::parse($item->created_at)->format('d') }}</h1>
                                            <p>{{ Carbon\Carbon::parse($item->created_at)->format('M') }}</p>
                                        </div>
                                    </div>
                                    <div class="news-grid-txt">
                                        <span>{{ $item->kategoriberita->nama_kategori }}</span>
                                        <h2>{{ $item->judul }}</h2>
                                        <ul>
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>
                                                {{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                {{ $item->userberita->username }}
                                            </li>
                                        </ul>
                                        <p>{{ $item->isi_berita }}</p>
                                        <a href="/admin/beritadetail/{{ $item->id }}">Baca Lebih Lanjut..</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

                <div class="mt-5 text-center mb-5">
                    <a href="/berita" class="btn-berita">Berita Lainnya</a>
                </div>

            </div>
        </section>

        <!-- Banner 2 -->
        <section class="page-section" id="tim-kami">
            <div class="container">
                <h1 class="banner-title text-center">Tim Kami</h1>
                <div class="text-center team-title">
                    <h1 class="mt-6">Created By</h1>
                    <h2>SIIBALA-TI Team's</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="{{ asset('img/banner/JAY.jpg') }}" alt="..." />
                            <h4>Joseph Angera Julyando</h4>
                            <p class="text-muted">2211083001</p>
                            <!-- <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a> -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="{{ asset('img/banner/MR.jpg') }}" alt="..." />
                            <h4>Muhamad Reza</h4>
                            <p class="text-muted">2211083033</p>
                            <!-- <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a> -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="{{ asset('img/banner/MAA.jpg') }}"
                                alt="..." />
                            <h4>Muhammad Abel Al-fahrezi</h4>
                            <p class="text-muted">2211083034</p>
                            <!-- <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a> -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="{{ asset('img/banner/pahri.jpg') }}"
                                alt="..." />
                            <h4>Muhammad Fahri</h4>
                            <p class="text-muted">2211083035</p>
                            <!-- <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                                                                                                                                                                                                        <a class="btn btn-dark btn-social mx-2" href="#!"
                                                                                                                                                                                                            aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a> -->
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
