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
                        <th>Info User</th>
                        <th class="text-center"><a href="/admin/user/{{$user->id }}/edit" class="link">Ubah Data</a></th>
                    </tr>
            </thead>
        
            <tbody>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>{{$data->nama}}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>{{$user->username}}</td>
                </tr>
                <tr>
                    @if($data->nip != "")
                    <td>NIP</td>
                    <td>{{$data->nip}}</td>
                    @elseif($data->nim != "")
                    <td>NIM</td>
                    <td>{{$data->nim}}</td>
                    @elseif($data->nik != "")
                    <td>NIK</td>
                    <td>{{$data->nik}}</td>
                    @else
                    <td>No Pengenal</td>
                    <td>-</td>
                    @endif
                
                </tr>
                <tr>
                    <td>Role</td>
                    <td>{{$user->role}}</td>
                </tr>
            </tbody>
        </table>
        <a href="/admin/user" class="btn btn-primary float-end mt-3">Kembali</a>
    </div>
@endsection
