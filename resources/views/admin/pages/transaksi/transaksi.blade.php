@extends('admin.layouts.template')

@section('main')
@can('isAdmin')
@include('admin.pages.transaksi.cardnavigasitransaksi')

@endcan
    <h2>Data Peminjaman/Pengembalian</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <div>
        @can('isAdmin')
        <a href="/admin/transaksipeminjaman" class="btn btn-primary my-3"style="width:15%">Peminjaman</a>
        <a href="/admin/transaksipengembalian" class="btn btn-primary my-3 "style="width:15%">Pengembalian</a>
        @endcan
    </div>
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
        @can('isAdmin')
        <form action="/admin/transaksi/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data?')">Remove</button>
          </form>
        @endcan
          <a href="/admin/transaksi/{{$item->id }}/edit" class="btn btn-success">Detail Transaksi</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
