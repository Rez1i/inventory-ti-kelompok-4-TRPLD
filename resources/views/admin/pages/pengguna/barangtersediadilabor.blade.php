@extends('admin.layouts.template')

@section('main')
    <div class="mb-3">
        <form action="/barangfilter" method="post">
            <div class="card p-3 py-4 shadow">
                <div class="align-items-center">
                    @csrf
                    <select name="kategoribarang_id" class="form-select col-2 d-inline">
                        <option value="-">Kategori Barang</option>
                        @foreach ($kategoribarang as $item)
                            @if ($kategoribarangselect == $item->id)
                                <option value="{{ $item->id }}" selected>{{ $item->nama_kategoribarang }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->nama_kategoribarang }}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="jenisbarang_id" class="form-select col-2 mx-2 d-inline">
                        <option value="-">Jenis Barang</option>
                        @foreach ($jenisbarang as $item)
                            @if ($jenisbarangselect == $item->id)
                                <option value="{{ $item->id }}" selected>{{ $item->nama_jenisbarang }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->nama_jenisbarang }}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="sifatbarang" class="form-select col-2 d-inline">
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
                    <select name="waktu" id="waktu" class="form-select col-2 d-inline mx-2">
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
                    <button type="submit" class="btn btn-primary mx-2">Filter</button>
                    <a href="/barang" class="btn btn-success">Hapus Filter</a>
                </div>
            </div>
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
        <div class="row">
            {{-- Tampilkan Barang jika semuabarang tidak kosong --}}
            @if ($semuabarang->isNotEmpty())
                <h3 class="mb-3">Barang</h3>
                @foreach ($semuabarang as $item)
                    <a href="/admin/barangdetail/{{ $item->id }}" class="col-lg-3 m-0 p-2 text-decoration-none">
                        <div class="card border-3 shadow" style="width: 100%; height: 26rem;" id="card-barang">
                            <img src="/storage/{{ $item->foto }}" class="card-img-top" alt="..."
                                style="width:100%;height:200px;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $item->namabarang }}-{{ $item->jenis_barang->nama_jenisbarang }}-{{ $item->jenis_barang->kategori_barang->nama_kategoribarang }}
                                </h5>
                                <p class="card-text">
                                    {{ $item->sifatbarang }} <br>
                                </p>
                                <p style="color: red;">
                                    <b>{{ $item->status }}</b> <br>
                                </p>
                                <p class="card-text">
                                    {{ $item->tahunpengadaan }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            {{-- Tampilkan BarangHp jika semuabaranghp tidak kosong --}}
            @if ($semuabaranghp->isNotEmpty())
                <h3 class="mb-3">Habis Pakai</h3>
                @foreach ($semuabaranghp as $item)
                    <a href="/admin/baranghpdetail/{{ $item->id }}" class="col-lg-3 m-0 p-2 text-decoration-none">
                        <div class="card border-3 shadow" style="width: 100%; height: 26rem;" id="card-barang">
                            <img src="/storage/{{ $item->foto }}" class="card-img-top" alt="..."
                                style="width:100%;height:200px;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $item->namabarang }}--{{ $item->kategori_baranghp->nama_kategoribarang }}</h5>
                                <p class="card-text">
                                    {{ $item->tahunpengadaan }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            {{-- Tampilkan pesan jika kedua foreach kosong --}}
            @if ($semuabarang->isEmpty() && $semuabaranghp->isEmpty())
                <div class="col-12">
                    <p>Tidak ada barang yang sesuai dengan filter.</p>
                </div>
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
                                    <a class="page-link" href="{{ $semuabarang->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li
                                class="page-item {{ $semuabarang->currentPage() == $semuabarang->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $semuabarang->nextPageUrl() }}">&raquo; Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>



@endsection
