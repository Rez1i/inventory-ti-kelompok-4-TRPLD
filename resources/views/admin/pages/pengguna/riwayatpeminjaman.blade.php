@extends('admin.layouts.template')

@section('main')
    <h2>Riwayat Peminjaman</h2>
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
                <th>Waktu Pengembalian</th>
                <th>Status</th>
                <th>Komentar dan Saran</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_peminjaman->namabarang}}</td>
        <td>{{ $item->waktupinjam}}</td>
        <td>{{ $item->waktudikembalikan}}</td>  
        <td>{{ $item->status}}</td>
        @if($item->sarankomentar == '-')
        <td>
            <b><a href="/sarankomentar/{{$item->id}}" class="link">Tambah Komentar atau Saran</a></b>
        </td>
        @else
            <td>{{$item->sarankomentar}}</td>
        @endif    
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
