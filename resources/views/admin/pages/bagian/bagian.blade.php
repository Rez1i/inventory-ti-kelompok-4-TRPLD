@extends('admin.layouts.template')

@section('main')
    <h2>Data Bagian Kerja Staff</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <a href="/admin/bagian/create" class="btn btn-primary my-3 "style="width:10%">Create</a>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Bagian Kerja</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama_bagian}}</td> 
        <td>{{ $item->keterangan}}</td> 
        <td>
        <form action="/admin/bagian/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
          </form>
          <a href="/admin/bagian/{{$item->id }}/edit" class="btn btn-success">Edit</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
