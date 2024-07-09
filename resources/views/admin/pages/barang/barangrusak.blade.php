@extends('admin.layouts.template')

@section('main')
@include('admin.pages.barang.cardnavigasibarang')
    @can('isAdmin')
        <h2 class="mb-5">Data Barang Rusak</h2>
    @endcan
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
    <form action="/admin/tambahbarangrusak" method="post">
        @csrf
        <div class="input-group mb-3 w-25 float-end">
            <input type="text" class="form-control" placeholder="Kode Barang" aria-describedby="button-addon2" name="kodebarang">
            <button class="btn btn-primary" type="submit" id="button-addon2">Tambah</button>
        </div>
    </form>
    @endcan
    <div class="table-responsive">
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->kodebarang}}</td> 
        <td>{{ $item->namabarang}}</td> 
        <td>{{ $item->jenis_barang->nama_jenisbarang }}</td> 
        <td>
        <form action="/admin/barangrusak/{{ $item->id }}" method="post" class="d-inline">
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data?')">Remove</button>
          </form>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection
