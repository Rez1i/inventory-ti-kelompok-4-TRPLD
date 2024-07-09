@extends('admin.layouts.template')

@section('main')
    <h1>Data User</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->username}}</td> 
        <td>{{ $item->email}}</td> 
        <td>{{ $item->role}}</td> 
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
