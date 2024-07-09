@extends('admin.layouts.template')

@section('main')
@can('isAdmin')
    <h2>Data Staff</h2>
    @endcan
    @can('isPimpinan')
    <h2>Staff Jurusan</h2>
    @endcan
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    @can('isAdmin')
    <div class="">
        <a href="/admin/staff/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
    </div> 
    @endcan
    <div class="table-responsive">
    <table id="example2" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Bagian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama}}</td> 
        <td>{{ $item->bagianstaff->nama_bagian }}</td>
        <td>
        @can('isAdmin')
        <form action="/admin/staff/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
          </form>
          @endcan
         
          <a href="/admin/staffdetail/{{$item->id }}" class="link"><b>Detail</b></a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection