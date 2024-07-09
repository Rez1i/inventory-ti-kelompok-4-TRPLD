@extends('admin.layouts.template')

@section('main')
@include('admin.pages.barang.cardnavigasibarang')
    <h1>Riwayat Penempatan Barang</h1>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Ruangan Asal</th>
                <th>Ruangan Terakhir</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_pemindahan->namabarang}}</td>
        <td>{{ $item->ruanganasal_pemindahan->nama_ruangan}}</td>
        <td>{{ $item->ruangantujuan_pemindahan->nama_ruangan}}</td>
        <td>{{ $item->alasan}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
