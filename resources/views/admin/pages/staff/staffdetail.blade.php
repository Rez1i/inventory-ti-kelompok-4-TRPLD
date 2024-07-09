@extends('admin.layouts.template')

@section('main')
    <div class="table-responsive">
    <table class="table table-bordered ">
    <thead>
            <tr>
                @can('isAdmin')
                <th>Info Staff</th>
                <th colspan="2" class="text-center"> <a href="/admin/staff/{{$staff->id }}/edit" class="link">Ubah Data</a></th>
                @endcan
                @can('isPimpinan')
                    <th colspan="3">Info Staff</th>
                @endcan

            </tr>
    </thead>
   
    <tbody>
        <tr>
            <td>Nama</td>
            <td>{{$staff->nama}}</td>
            @if($staff->foto == "-")
            <td style="width: 200px;" rowspan="4"><img src="/storage/defaultfoto.png" alt="default" style="width:200px;height:200px;"></td>
            @else
            <td style="width: 200px;" rowspan="4"><img src="/storage/{{$staff->foto}}" alt="foto staff" style="width:200px;height:200px;"></td>
            @endif
        </tr>
        <tr>
            <td>NIP</td>
            <td>{{$staff->nik}}</td>
           
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$staff->email}}</td>
        </tr>
        <tr>
            <td>No Telfon</td>
            <td>{{$staff->no_telp}}</td>
        </tr>
        <tr>
            <td>Bagian</td>
            <td colspan="2">{{$staff->bagianstaff->nama_bagian}}</td>
        </tr>
    </tbody>
    </table>
        <a href="/admin/staff" class="btn btn-primary float-end">Kembali</a>
    </div>
@endsection
