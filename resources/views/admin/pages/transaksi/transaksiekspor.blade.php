@extends('admin.layouts.template')

@section('main')
    <h1>Data Transaksi</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Email Peminjam</th>
                <th>Penanggung Jawab</th>
                <th>Waktu Peminjaman</th>
                <th>Batas Waktu</th>
                <th>Waktu Pengembalian</th>
                <th>Status Transaksi</th>
                <th>Saran Dan Komentar</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{$item->barang_peminjaman->namabarang}}</td> 
        <td>{{$item->peminjam}}</td> 
        <td>{{$item->penanggung_jawab_peminjaman->email}}</td>
        <td>{{$item->waktupinjam}}</td>
        <td>{{$item->bataswaktu }}</td>
        <td>{{$item->waktudikembalikan}}</td>
        <td>{{$item->status}}</td>
        <td>{{$item->sarankomentar}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection

