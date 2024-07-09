@extends('admin.layouts.template')

@section('main')
<h1>Create New Data</h1>

<form method="post" action="/admin/ruangan">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
        <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan">
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <input id="body" type="hidden" name="keterangan">
        <trix-editor input="body"></trix-editor>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection