@extends('admin.layouts.template')

@section('main')
@include('admin.pages.barang.cardnavigasibarang')
    <h2>Data Penempatan Barang</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <a href="/admin/penempatan/create" class="btn btn-primary my-3 "style="width:10%">Create</a>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Nama Ruangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->barang_penempatan->namabarang}}</td>
        <td>{{ $item->ruangan_penempatan->nama_ruangan}}</td>
        <td>
        <form action="/admin/penempatan/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
          </form>
          <a href="/admin/penempatan/{{$item->id }}/edit" class="btn btn-success">Edit</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
