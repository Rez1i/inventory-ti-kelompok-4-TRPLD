@extends('admin.layouts.template')

@section('main')
    <h1>Detail Transaksi</h1>
   
    <div class="table-responsive">
    <table class="table">
    <thead>
            <tr>
                <th colspan="2">Information</th>
            </tr>
    </thead>
   
    <tbody>
        <tr>
            <td>Peminjam</td>
            <td>{{$transaksi->peminjam}}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{$transaksi->barang_peminjaman->namabarang}}</td>
           
        </tr>
        <tr>
            <td>Penanggung Jawab</td>
            <td>{{$transaksi->penanggung_jawab_peminjaman->email}}</td>
        </tr>
        <tr>
            <td>Waktu Pinjam</td>
            <td>{{$transaksi->waktupinjam}}</td>
        </tr>
        <tr>
            <td>Batas Waktu</td>
            <td>{{$transaksi->bataswaktu }}</td>
        </tr>
        <tr>
            <td>Waktu Dikembalikan</td>
            <td>{{$transaksi->waktudikembalikan}}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{$transaksi->status}}</td>
        </tr>
        <tr>
            <td>Saran/Komentar</td>
            <td>{{$transaksi->sarankomentar}}</td>
        </tr>
    </tbody>
    </table>
        <a href="/admin/transaksi" class="btn btn-primary float-end my-3">Kembali</a>
    </div>
@endsection
