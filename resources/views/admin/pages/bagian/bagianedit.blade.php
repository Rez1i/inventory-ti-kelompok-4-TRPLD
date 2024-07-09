@extends('admin.layouts.template')

@section('main')
<h1>Update Data</h1>

<form method="post" action="/admin/bagian/{{$bagian->id}}">
    @csrf
    @method('put')
    <div class="width-75">
    <div class="mb-3">
        <label for="nama_bagian" class="form-label">Nama Program Studi</label>
        <input type="text" class="form-control" id="nama_bagian" name="nama_bagian" value="{{$bagian->nama_bagian}}">
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{$bagian->keterangan}}">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection