@extends('admin.layouts.template')

@section('main')
    <h1>Data Dosen</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>NIP</th>
                <th>Email</th>
                <th>No Telfon</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama}}</td> 
        <td>{{ $item->nip}}</td> 
        <td>{{ $item->email}}</td>
        <td>{{ $item->no_telp}}</td>
        <td>{{ $item->jabatan}}</td>  
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
