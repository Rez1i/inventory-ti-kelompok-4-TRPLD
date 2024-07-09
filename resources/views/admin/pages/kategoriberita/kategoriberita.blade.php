@extends('admin.layouts.template')

@section('main')
    @include('admin.pages.berita.cardberita')
    <h1>Data Kategori Berita</h1>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <a href="/admin/kategoriberita/create" class="btn btn-primary my-3 "style="width:10%">Create</a>
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <form action="/admin/kategoriberita/{{ $item->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger"
                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">Remove</button>
                        </form>
                        <a href="/admin/kategoriberita/{{ $item->id }}/edit" class="btn btn-success">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
