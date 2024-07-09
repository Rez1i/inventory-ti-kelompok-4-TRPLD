@extends('admin.layouts.template')

@section('main')
@include('admin.pages.barang.cardnavigasibarang')
    <h2>Data Satuan Barang</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <div class="">
        <a href="/admin/satuan/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
    </div>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Satuan</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama_satuan}}</td> 
        <td>{{ $item->keterangan}}</td>
        <td>
        <form action="/admin/satuan/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data?')">Remove</button>
          </form>
          <a href="/admin/satuan/{{$item->id }}/edit" class="btn btn-success">Edit</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
