@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" id="Beranda" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Detail Barang</h2>
                    </div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="3">Info Barang</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Kode Barang</td>
                                        <td>{{ $barang->kodebarang }}</td>
                                        @if ($barang->foto == '-')
                                            <td style="width: 270px;" rowspan="6"><img src="/storage/defaultfoto.png"
                                                    alt="default" style="width:250px;height:250px;"></td>
                                        @else
                                            <td style="width: 270px;" rowspan="6"><img src="/storage/{{ $barang->foto }}"
                                                    alt="foto barang" style="width:250px;height:250px;"></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td>{{ $barang->namabarang }}</td>

                                    </tr>
                                    <tr>
                                        <td>Jenis Barang</td>
                                        <td>{{ $barang->jenis_barang->nama_jenisbarang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>{{ $barang->status }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tahun Pengadaan</td>
                                        <td>{{ $barang->tahunpengadaan }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            @if ($barang->statuspengajuan == 1)
                                                <a href="/barang" class="btn btn-primary float-end mx-2">Kembali</a>
                                            @else
                                                <form action="/pengajuanpeminjaman/{{ $barang->id }}" method="post">
                                                    @csrf
                                                    <a href="/barang" class="btn btn-primary float-end mx-2">Kembali</a>
                                                    <input type="submit" value="Ajukan Peminjaman"
                                                        class="btn btn-success float-end">
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
