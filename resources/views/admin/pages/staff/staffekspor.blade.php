@extends('admin.layouts.template')

@section('main')
    <h1>Data Staff</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Staff</th>
                <th>NIK</th>
                <th>Email</th>
                <th>No Telfon</th>
                <th>Bagian Kerja</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama}}</td> 
        <td>{{ $item->nik}}</td> 
        <td>{{ $item->email}}</td>
        <td>{{ $item->no_telp}}</td>
        <td>{{ $item->bagianstaff->nama_bagian}}</td>  
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
