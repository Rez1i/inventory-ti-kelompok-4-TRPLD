@extends('admin.layouts.template')

@section('main')
    <h2>Data User</h2>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
    <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <a href="/admin/user/create" class="btn btn-primary my-3 "style="width:10%">Create</a>
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->username}}</td> 
        <td>{{ $item->email}}</td> 
        <td>{{ $item->role}}</td> 
        <td>
        @if($item->role == 'Admin')
        <form action="#" method="get" class="d-inline">
            @csrf
            <button class="btn btn-danger disabled" >Remove</button>
          </form>
          <a href="#" class="btn btn-warning disabled">Detail</a>

        @else
        <form action="/admin/user/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Semua data yang berhubungan dengan user ini akan dihapus, anda yakin??')">Remove</button>
          </form>
          <a href="/admin/userdetail/{{$item->id }}" class="btn btn-warning">Detail</a>

        @endif
        
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
