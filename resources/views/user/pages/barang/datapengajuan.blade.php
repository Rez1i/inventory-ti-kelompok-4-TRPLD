@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" id="Beranda" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Pengajuan Peminjaman</h2>
                        <div class="mt-4 mb-4">
                            <br>
                            <a href="/barang" class="btn-navbar">Kembali</a>
                        </div>
                    </div>
                    @if($data->count() != 0)
                    <div class="card m-1 p-4">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('success'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('failed') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID Pengajuan</th>
                                        <th>Nama Barang</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->pengajuanbarang->namabarang }}</td>
                                            <td>{{ $item->status }}</td>
                                            @if ($item->status == 'Sudah Diproses')
                                                <td>-</td>
                                            @elseif($item->status == 'Ditolak')
                                                <td>-</td>
                                            @else
                                                <td class="text-center">
                                                    <b>
                                                        <a href="/pengajuanbatal/{{ $item->id }}"
                                                            class="link">Batalkan Pengajuan</a>
                                                    </b>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>




                    </div>
                    @else
                    <h3 class="text-center">Anda Tidak Memiliki Pengajuan Peminjaman</h3>
                    @endif
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
