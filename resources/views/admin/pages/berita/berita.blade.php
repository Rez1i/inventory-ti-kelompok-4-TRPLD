@extends('admin.layouts.template')

@section('main')
    @include('admin.pages.berita.cardberita')
    <h1>Data Berita</h1>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <div class="">
        <a href="/admin/berita/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto">Create</a>
    </div>
    <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
    <div class="table-responsive">
        <table id="example2" class="table table-bordered ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->userberita->username }}</td>
                        <td>{{ $item->kategoriberita->nama_kategori }}</td>
                        <td>
                            <form action="/admin/berita/{{ $item->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger"
                                    onclick="return confirm('Anda yakin ingin menghapus data ini?')">Remove</button>
                            </form>
                            <a href="/admin/berita/{{ $item->id }}/edit" class="btn btn-success">Edit</a>
                            <a href="/admin/beritadetail/{{ $item->id }}" class="btn btn-warning">Look</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
