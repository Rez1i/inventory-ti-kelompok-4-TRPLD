@extends('admin.layouts.template')

@section('main')
    <h2>Data Program Studi</h2>
    <div class="">
        <a href="/admin/prodi/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
        <a href="/admin/sinkronprodi" class="btn btn-success">Sinkron</a>
    </div>

    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Jenjang Studi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama_prodi}}</td>
        <td>{{ $item->jenjangstudi}}</td>
        <td>
        <form action="/admin/prodi/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
          </form>
          <a href="/admin/prodi/prodidetail/{{$item->id}}" class="btn btn-success">Detail</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
