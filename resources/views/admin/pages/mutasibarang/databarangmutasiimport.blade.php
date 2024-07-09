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
<form action="/admin/mutasibarang/import" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <p>Pastikan File yang ingin anda upload tersusun seperti <a href="/admin/contohfilemutasi"><b>Contoh File</b></a> . Pastikan kode barang sudah terdafter 
        di sistem. Menambahkan data barang yang dimutasi berarti menghapus data barang yang ada di sistem !!.
        </p>
        <p>Pastikan file adalah file .xlsx, .xls, .csvx</p>
        <input type="hidden" value="{{$mutasi_id}}" name="mutasi_id">
        <input class="form-control" type="file" id="formFile" name="file" accept=".xlsx, .xls, .csv">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


