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
                    <th>Detail Data Dosen</th>
                    <th colspan="2" class="text-center"> <a href="/admin/dosen/{{$dosen->id }}/edit" class="link">Ubah Data</a></th>
                @endcan
                @can('isPimpinan')
                    <th colspan="3">Detail Data Dosen</th>

                @endcan

            </tr>
    </thead>

    <tbody>
        <tr>
            <td>Nama</td>
            <td>{{$dosen->nama}}</td>
            @if($dosen->foto == "-")
            <td style="width: 250px;" rowspan="5"><img src="/storage/defaultfoto.png" alt="default" style="width:250px;height:250px;"></td>
            @else
            <td style="width: 250px;" rowspan="5"><img src="/storage/{{$dosen->foto}}" alt="foto dosen" style="width:250px;height:250px;"></td>
            @endif
        </tr>
        <tr>
            <td>NIP</td>
            <td>{{$dosen->nip}}</td>

        </tr>
        <tr>
            <td>Email</td>
            <td>{{$dosen->email}}</td>
        </tr>
        <tr>
            <td>No Telfon</td>
            <td>{{$dosen->no_telp}}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>{{$dosen->jabatan}}</td>
        </tr>
    </tbody>
    </table>
        <a href="/admin/dosen" class="btn btn-primary float-end mt-3">Kembali</a>
    </div>
@endsection
