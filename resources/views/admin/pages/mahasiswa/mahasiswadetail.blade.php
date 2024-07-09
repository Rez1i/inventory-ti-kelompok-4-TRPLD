@extends('admin.layouts.template')

@section('main')
@if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
   <div class="table-responsive">
    <table class="table">
    <thead>
            <tr>
                @can('isAdmin')
                <th>Info Mahasiswa</th>
                <th colspan="2" class="text-center"> <a href="/admin/mahasiswa/{{$mahasiswa->id }}/edit" class="link">Ubah Data</a></th>
                @endcan
                @can('isPimpinan')
                    <th colspan="3">Info Mahasiswa</th>
                @endcan
            </tr>
    </thead>
   
    <tbody>
        <tr>
            <td>Nama Lengkap</td>
            <td>{{$mahasiswa->nama}}</td>
            @if($mahasiswa->foto == "-")
            <td style="width: 270px;" rowspan="5"><img src="/storage/defaultfoto.png" alt="default" style="width:270px;height:250px;"></td>
            @else
            <td style="width: 270px;" rowspan="5"><img src="/storage/{{$mahasiswa->foto}}" alt="foto mahasiswa" style="width:270px;height:250px;"></td>
            @endif
        </tr>
        <tr>
            <td>NIM</td>
            <td>{{$mahasiswa->nim}}</td>
           
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>{{$mahasiswa->prodi->nama_prodi}}</td>
           
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$mahasiswa->email}}</td>
        </tr>
        <tr>
            <td>No Telfon</td>
            <td>{{$mahasiswa->no_telp}}</td>
        </tr>
    </tbody>
    </table>
        <a href="/admin/mahasiswa" class="btn btn-primary float-end mt-3">Kembali</a>
    </div>
@endsection
