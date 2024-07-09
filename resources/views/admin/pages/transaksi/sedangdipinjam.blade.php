@extends('admin.layouts.template')

@section('main')
@include('admin.pages.transaksi.cardnavigasitransaksi')
    <h2>Data Peminjaman yang sedang berlangsung (belum dikembalikan)</h2>
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
                <th>Email Peminjam</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_peminjaman->namabarang}}</td> 
        <td>{{ $item->peminjam}}</td>
        <td>{{ $item->status}}</td> 
        <td>
        <a href="/admin/transaksi/{{$item->id }}/edit" class="btn btn-success">Detail Transaksi</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
