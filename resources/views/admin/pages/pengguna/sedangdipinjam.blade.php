@extends('admin.layouts.template')

@section('main')
    <h2>Sedang Dipinjam</h2>
    @if(session()->has('success'))
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
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_peminjaman->namabarang}}</td>
        <td>{{ $item->waktupinjam}}</td>
        <td>{{ $item->bataswaktu}}</td>
        @if($item->masapinjam != 0)
            <td>{{ $item->masapinjam }} Hari lagi</td>
        @else
            <td>Segera Lakukan Pengembalian Barang</td>
        @endif
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
