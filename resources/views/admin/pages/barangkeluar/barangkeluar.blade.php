@extends('admin.layouts.template')

@section('main')
@can('isAdmin')
    @include('admin.pages.transaksi.cardnavigasitransaksi')
@endcan
    <h2>Data Barang Keluar</h2>
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
        <a href="/admin/barangkeluar/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
    </div> 
   @endcan
    <div class="table-responsive">
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Banyak Barang</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_keluar->namabarang}}</td> 
        <td>{{ $item->banyakbarang }} {{ $item->satuanbarangkeluar->nama_satuan }}</td> 
        <td>
            @can('isAdmin')
        <form action="/admin/barangkeluar/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Anda Yakin Ingin Menghapus Data?')">Remove</button>
          </form>
          @endcan
          <a href="/admin/barangkeluardetail/{{$item->id }}" class="btn btn-warning">Detail</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection
