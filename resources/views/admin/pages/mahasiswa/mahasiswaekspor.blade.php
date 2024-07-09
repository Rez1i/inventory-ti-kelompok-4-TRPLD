@extends('admin.layouts.template')

@section('main')
    <h1>Data Mahasiswa</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>No Telpon</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->nama}}</td>
        <td>{{ $item->nim}}</td>
        <td>{{ $item->email}}</td>
        <td>{{ $item->prodi->nama_prodi }}</td>
        <td>{{ $item->no_telp}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
