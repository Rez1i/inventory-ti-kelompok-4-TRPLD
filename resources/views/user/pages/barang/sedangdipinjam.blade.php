@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" id="Beranda" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Sedang Dipinjam</h2>
                        <div class="mt-4 mb-4">
                            <br>
                            <a href="/barang" class="btn-navbar">Kembali</a>
                        </div>
                    </div>
                    @if($data)
                    <div class="card m-1 p-4">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('Failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('Failed') }}
                            </div>
                        @endif
                        <table id="example2" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Waktu Peminjaman</th>
                                    <th>Batas Waktu Peminjaman</th>
                                    <th>Sisa Masa Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->barang_peminjaman->namabarang }}</td>
                                        <td>{{ $item->waktupinjam }}</td>
                                        <td>{{ $item->bataswaktu }}</td>
                                        @if ($item->masapinjam != 0)
                                            <td>{{ $item->masapinjam }} Hari lagi</td>
                                        @else
                                            <td>Segera Lakukan Pengembalian Barang</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                    @else
                    <h3 class="text-center">Anda Tidak Memiliki Barang Yang Sedang Dipinjam</h3>
                    @endif
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
