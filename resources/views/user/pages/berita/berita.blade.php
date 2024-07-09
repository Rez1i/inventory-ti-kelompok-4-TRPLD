@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" id="Beranda" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Berita Terbaru</h2>
                    </div>
                    @if($beritaterbaru->count() != 0)
                    <div class="card shadow p-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="news-slider-terbaru" class="owl-carousel">

                                    <!-- 1 -->
                                    @foreach ($beritaterbaru->take(5) as $item)
                                        <div class="news-grid">
                                            <div class="news-grid-image"><img src="/storage/{{ $item->gambar }}"
                                                    alt="">
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
                                                <a href="/admin/beritadetail/{{ $item->id }}">Baca Lebih Lanjut...</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                    @else
                        <h3 class="text-center">Tidak Ada Berita Terbaru</h3>
                    @endif
                </div>
            </div>
        </section>

        @if ($beritalainnya->count() != 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <form action="/beritafilter" method="GET">
                        @csrf
                        <div class="card p-3 py-4 mt-4 shadow">
                            <h1 class="banner-title text-center">Pilih Kategori</h1>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <select name="kategori_id" class="form-select">
                                        <option value="-">Pilih Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ $kategoriselect == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select name="waktu" class="form-select">
                                        <option value="asc" {{ $waktu == 'asc' ? 'selected' : '' }}>Urut Terlama
                                        </option>
                                        <option value="desc" {{ $waktu == 'desc' ? 'selected' : '' }}>Urut Terbaru
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="/beritafilter" class="btn btn-success">Hapus Filter</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if ($beritalainnya->isNotEmpty())
            <section class="page-section" id="tim-kami" style="margin-top: -120px">
                <div class="container">
                    <div class="card shadow p-4">
                        <h1 class="banner-title text-center">Berita Lainnya</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                @foreach ($beritalainnya as $item)
                                    <div class="news-grid">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="news-grid-image"><img src="/storage/{{ $item->gambar }}"
                                                        alt="">
                                                    <div class="news-grid-box">
                                                        <h1>{{ Carbon\Carbon::parse($item->created_at)->format('d') }}</h1>
                                                        <p>{{ Carbon\Carbon::parse($item->created_at)->format('M') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-8">
                                                <div class="news-grid-txt">
                                                    <span>{{ $item->kategoriberita->nama_kategori }}</span>
                                                    <h2>{{ $item->judul }}</h2>
                                                    <ul>
                                                        <li><i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                                        </li>
                                                        <li><i class="fa fa-user" aria-hidden="true"></i>
                                                            {{ $item->userberita->username }}</li>
                                                    </ul>
                                                    <p>{{ Str::limit($item->isi_berita, 100) }}</p>
                                                    <a href="/admin/beritadetail/{{ $item->id }}">Baca Lebih
                                                        Lanjut...</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            @if ($beritalainnya->previousPageUrl())
                                <a href="{{ $beritalainnya->previousPageUrl() }}" class="btn btn-primary mx-1">&laquo;
                                    Previous</a>
                            @else
                                <span class="btn btn-secondary disabled mx-1">&laquo; Previous</span>
                            @endif

                            @if ($beritalainnya->nextPageUrl())
                                <a href="{{ $beritalainnya->nextPageUrl() }}" class="btn btn-primary mx-1">Next &raquo;</a>
                            @else
                                <span class="btn btn-secondary disabled mx-1">Next &raquo;</span>
                            @endif
                        </div>

                    </div>
                </div>

            </section>
        @endif



    </main>
@endsection
