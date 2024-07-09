@extends('admin.layouts.template')

@section('main')
    @can('isAdmin')
        <h2>Detail Barang</h2>

        <div class="table-responsive">
            <table class="table">
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
                            <td style="width: 280px;" rowspan="6"><img src="/storage/defaultfoto.png" alt="default"
                                    style="width:280px;height:270px;"></td>
                        @else
                            <td style="width: 280px;" rowspan="6"><img src="/storage/{{ $barang->foto }}" alt="foto barang"
                                    style="width:280px;height:270px;"></td>
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
                        <td>Kondisi</td>
                        <td>{{ $barang->kondisi }}</td>
                    </tr>
                    <tr>
                        <td>Sifat Barang</td>
                        <td>{{ $barang->sifatbarang }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $barang->status }}</td>
                    </tr>
                    <tr>
                        <td>Tahun Pengadaan</td>
                        <td>{{ $barang->tahunpengadaan }}</td>
                        <td class="text-center">
                            <img src="/storage/{{ $barang->barcode }}" alt="foto barang">
                            <br>
                            {{ $barang->kodebarang }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="my-5">Riwayat Peminjaman</h2>
            <div class="table-responsive my-3">
                <table id="example2" class="table ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Peminjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatpeminjaman as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->waktupinjam }}</td>
                                <td>{{ $item->peminjam }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>

                <h2 class="my-3">Riwayat Penempatan </h2>
                <div class="table-responsive my-3">
                    <table id="example2" class="table  ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ruangan Sebelumnya</th>
                                <th>Ruangan Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayatpindah as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->ruanganasal_pemindahan->nama_ruangan }}</td>
                                    <td>{{ $item->ruangantujuan_pemindahan->nama_ruangan }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="/admin/barang" class="btn btn-primary float-end">Kembali</a>
            </div>
        </div>
    @endcan
    @can('isUser')
        <h2>Detail Barang</h2>
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
            <table class="table">
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
                            <td style="width: 270px;" rowspan="6"><img src="/storage/defaultfoto.png" alt="default"
                                    style="width:250px;height:250px;"></td>
                        @else
                            <td style="width: 270px;" rowspan="6"><img src="/storage/{{ $barang->foto }}" alt="foto barang"
                                    style="width:250px;height:250px;"></td>
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
                                    <input type="submit" value="Ajukan Peminjaman" class="btn btn-success float-end">
                                </form>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>



        </div>
    @endcan
@endsection
