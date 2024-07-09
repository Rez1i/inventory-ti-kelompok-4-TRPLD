@extends('admin.layouts.template')

@section('main')
@can('isAdmin')
    @include('admin.pages.transaksi.cardnavigasitransaksi')
@endcan
    <h2>Data Barang Masuk</h2>
    {{-- Display success or failure messages --}}
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    @can('isAdmin')
    <div class="">
        <a href="/admin/tambahbarang" class="btn btn-primary mt-1 mb-3 col-2 d-inline-block" style="width:auto" >Tambah Data</a>
    </div>
    @endcan

    <div class="table-responsive">
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Vendor</th>
                <th>Total Item</th>
                <th>Tahun Pengadaan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->pemasok}}</td>
        <td>{{ $item->stock }}</td>
        <td>{{ $item->tahunpengadaan }}</td>
        <td>
          <a href="/admin/inputbarangmasuk/{{$item->id }}" class="btn btn-success">Lihat Data</a>
          @if($item->laporan != '-')
            <a href="/admin/inputbarangmasuk/downloadlaporan/{{$item->id }}" class="btn btn-warning">Laporan</a>
          @else
          <a href="#" class="btn btn-warning disabled" >Laporan</a>
          @endif
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection
