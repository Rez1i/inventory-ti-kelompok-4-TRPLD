@extends('admin.layouts.template')

@section('main')
    @can('isAdmin')
    <h2>Data Mahasiswa</h2>
    @endcan
    @can('isPimpinan')
    <h2>Mahasiswa Jurusan</h2>
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
    <div class="">
        <a href="/admin/mahasiswa/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
        <a href="/admin/sinkronmahasiswa" class="btn btn-success">Tambah Data Otomatis</a>
    </div>
    @endcan
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama}}</td>
        <td>{{ $item->prodi->nama_prodi }}</td>
        <td>
        @can('isAdmin')
        <form action="/admin/mahasiswa/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
          </form>
          <a href="/admin/mahasiswadetail/{{$item->id }}" class="btn btn-warning"><b>Detail</b></a>
         @endcan
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
