@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" id="Beranda" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h1 class="welcome-title mb-2">
                            Selamat Datang di</h1>
                        <h2 class="welcome-title">Halaman Barang Labor</h2>
                        <h2 class="welcome-title mb-4">Di Jurusan Teknologi Informasi</h2>
                        <div class="mt-4 mb-4">
                            <br>
                            <a href="/pengajuanpeminjaman" class="btn-navbar">Pengajuan Peminjaman</a>
                            <a href="/sedangdipinjam" class="btn-navbar">Sedang Dipinjam</a>
                            <a href="/riwayatpeminjaman" class="btn-navbar">Riwayat Peminjaman</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="mb-3">
                    <form action="/barangfilter" method="post">
                        @if ($semuabarang->isNotEmpty())
                            <div class="card p-3 py-4 shadow">
                                <h1 class="banner-title text-center">Pilih Kategori</h1>
                                <div class="row text-center">
                                    @csrf
                                    <div class="col-lg-2">
                                        <select name="kategoribarang_id" class="form-select d-inline">
                                            <option value="-">Kategori Barang</option>
                                            @foreach ($kategoribarang as $item)
                                                @if ($kategoribarangselect == $item->id)
                                                    <option value="{{ $item->id }}" selected>
                                                        {{ $item->nama_kategoribarang }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->nama_kategoribarang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="jenisbarang_id" class="form-select d-inline">
                                            <option value="-">Jenis Barang</option>
                                            @foreach ($jenisbarang as $item)
                                                @if ($jenisbarangselect == $item->id)
                                                    <option value="{{ $item->id }}" selected>
                                                        {{ $item->nama_jenisbarang }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->nama_jenisbarang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="sifatbarang" class="form-select d-inline">
                                            @if ($sifatbarangselect == 'Boleh Dipinjam')
                                                <option value="-">Sifat Barang</option>
                                                <option value="Boleh Dipinjam" selected>Boleh Dipinjam</option>
                                                <option value="Tidak Boleh Dipinjam">Tidak Boleh Dipinjam</option>
                                            @elseif($sifatbarangselect == 'Tidak Boleh Dipinjam')
                                                <option value="-">Sifat Barang</option>
                                                <option value="Boleh Dipinjam">Boleh Dipinjam</option>
                                                <option value="Tidak Boleh Dipinjam" selected>Tidak Boleh Dipinjam</option>
                                            @else
                                                <option value="-" selected>Sifat Barang</option>
                                                <option value="Boleh Dipinjam">Boleh Dipinjam</option>
                                                <option value="Tidak Boleh Dipinjam">Tidak Boleh Dipinjam</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="waktu" id="waktu" class="form-select d-inline">
                                            @if ($waktu == 'desc')
                                                <option value="-">Waktu</option>
                                                <option value="desc" selected>Urut Terbaru</option>
                                                <option value="asc">Urut Terlama</option>
                                            @elseif($waktu == 'asc')
                                                <option value="-">Waktu</option>
                                                <option value="desc">Urut Terbaru</option>
                                                <option value="asc" selected>Urut Terlama</option>
                                            @else
                                                <option value="-" selected>Waktu</option>
                                                <option value="desc">Urut Terbaru</option>
                                                <option value="asc">Urut Terlama</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="/barang" class="btn btn-success">Hapus Filter</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
                <!-- <div class="">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <a href="/barang" class="link flex-row mx-3"><b>Semua</b></a>
                                                                                                                                                                                                                                                                                                                                                                                                                                    @foreach ($jenisbarang as $itemjenis)
    <a href="/barangfilter/{{ $itemjenis->id }}" class="link flex-row mx-3"><b>{{ $itemjenis->nama_jenisbarang }}</b></a>
    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif(session()->has('success'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('failed') }}
                    </div>
                @endif
                <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
                <div class="card p-4 shadow">
                    @if ($semuabarang->isNotEmpty())
                        <div class="row">
                            {{-- Tampilkan Barang jika semuabarang tidak kosong --}}

                            <h1 class="banner-title text-center">Barang Tetap</h1>
                            @foreach ($semuabarang as $item)
                                <a href="/admin/barangdetail/{{ $item->id }}"
                                    class="col-lg-3 m-0 p-2 text-decoration-none">
                                    <div class="card shadow"
                                        style="width: 100%; height: 30rem; border-radius: 20px; border: 2px #ffa552 solid;"
                                        id="card-barang">
                                        <div class="col-12 text-center text-white"
                                            style="border-radius: 20px 20px 0 0; align-items: center; background-color: #ffa552;">
                                            <h6 style="margin-top: 5px;">{{ $item->status }}</h6>
                                        </div>
                                        @if ($item->foto != '-')
                                            <img src="/storage/{{ $item->foto }}" class="card-img-top" alt="..."
                                                style="width:100%;height:200px; border-radius: 0 0 0 0;">
                                        @else
                                            <img src="/storage/defaultfoto.png" class="card-img-top" alt="..."
                                                style="width:100%;height:200px; border-radius: 0 0 0 0;">
                                        @endif
                                        <div class="card-body">
                                            <ul style="margin-top:-10px; margin-bottom: -10px;">
                                                <li><i class="fa-solid fa-calendar-plus" aria-hidden="true"></i>
                                                    {{ $item->tahunpengadaan }}</li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                                    {{ $item->jenis_barang->kategori_barang->nama_kategoribarang }}
                                                </li>
                                                <li><i class="fa-solid fa-list" aria-hidden="true"></i>
                                                    {{ $item->jenis_barang->nama_jenisbarang }}</li>
                                            </ul>
                                            <p style="text-align: justify; border-bottom: 2px solid #ececec;">
                                                {{ $item->namabarang }}
                                            </p>
                                            @if ($item->sifatbarang == 'Tidak Boleh Dipinjam')
                                                <h6 class="text-center text-white"
                                                    style="padding: 5px; margin: 0 30px 0 30px; border-radius: 5px; background-color:red">
                                                    <i class="fa-solid fa-square-xmark"></i> Tidak Boleh Dipinjam
                                                </h6>
                                            @elseif ($item->sifatbarang == 'Boleh Dipinjam')
                                                <h6 class="text-center text-white"
                                                    style="padding: 5px; margin: 0 50px 0 50px; border-radius: 5px; background-color:green">
                                                    <i class="fa-solid fa-square-check"></i> Boleh Dipinjam
                                                </h6>
                                            @endif
                                            <div class="text-center text-white">
                                                {{ $item->sifatbarang }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>


                        {{-- Tampilkan BarangHp jika semuabaranghp tidak kosong --}}
                        @if ($semuabaranghp->isNotEmpty())
                            <h1 class="banner-title text-center mt-4">Barang Habis Pakai</h1>
                            <div class="row">
                                @foreach ($semuabaranghp as $item)
                                    <a href="/admin/baranghpdetail/{{ $item->id }}"
                                        class="col-lg-3 m-0 p-2 text-decoration-none">
                                        <div class="card shadow"
                                            style="width: 100%; height: 20rem; border-radius: 20px; border: 2px Solid #ffa552;"
                                            id="card-barang">
                                            <img src="/storage/{{ $item->foto }}" class="card-img-top" alt="..."
                                                style="width:100%;height:200px; border-radius: 20px 20px 0 0;">
                                            <div class="card-body">
                                                <ul>
                                                    <li><i class="fa-solid fa-calendar-plus" aria-hidden="true"></i>
                                                        {{ $item->tahunpengadaan }}</li>
                                                    <li>
                                                        <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                                        {{ $item->kategori_baranghp->nama_kategoribarang }}
                                                    </li>
                                                </ul>
                                                <p style="text-align: justify; margin-top: 5px;">
                                                    {{ $item->namabarang }}
                                                </p>

                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        {{-- Tampilkan pesan jika kedua foreach kosong --}}
                        @if ($semuabarang->isEmpty() && $semuabaranghp->isEmpty())
                            <div class="card p-4 shadow">
                                <div class="row">
                                    <div class="col-12">
                                        <p>Tidak ada barang yang sesuai dengan filter.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <h3 class="text-center">Data Barang Tidak Ada</h3>
                    @endif
                </div>


                <div class="d-flex justify-content-end mt-4">
                    @if ($semuabarang->lastPage() > 1)
                        <div class="d-flex justify-content-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item {{ $semuabarang->currentPage() == 1 ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $semuabarang->previousPageUrl() }}" tabindex="-1"
                                            aria-disabled="true">&laquo; Previous</a>
                                    </li>
                                    @for ($i = 1; $i <= $semuabarang->lastPage(); $i++)
                                        <li class="page-item {{ $semuabarang->currentPage() == $i ? ' active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $semuabarang->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li
                                        class="page-item {{ $semuabarang->currentPage() == $semuabarang->lastPage() ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $semuabarang->nextPageUrl() }}">&raquo;
                                            Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>


            </div>


        </section>

    </main>
@endsection
