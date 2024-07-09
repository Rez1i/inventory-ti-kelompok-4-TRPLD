@extends('admin.layouts.template')
@section('main')
<h4>Note!!</h4>
@if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
@elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
@endif
<form action="/admin/staff/import" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <p>Pastikan File yang ingin anda upload tersusun seperti <a href="/admin/contohfilestaff"><b>Contoh File</b></a> . Sesuaikan bagian kerja
        dengan tabel bagian kerja. Jangan lupa untuk memastikan email dan nik dari Staff tidak sama dengan yang lain. Jika sama, Sistem tidak akan menambahkan
        data tersebut ke database!!.
        </p>
        <p>Pastikan file adalah file .xlsx, .xls, .csvx</p>
        <input class="form-control" type="file" id="formFile" name="file" accept=".xlsx, .xls, .csv">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


