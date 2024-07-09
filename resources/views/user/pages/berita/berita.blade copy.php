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
                    <div class="card p-5">
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
                </div>
            </div>
        </section>

        @if ($semuabarang->isNotEmpty())
            <section class="page-section" id="tim-kami">
                <div class="container">
                    <h1 class="banner-title text-center">Berita Lainnya</h1>
                    <div class="card p-4">
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
