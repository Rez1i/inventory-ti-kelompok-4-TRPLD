@extends('admin.layouts.template')

@section('main')


<form method="post" action="/sarankomentar">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="komentar" class="form-label">Komentar dan Saran</label>
        <input type="hidden" name="id" value="{{$id}}">  
        <input id="body" type="hidden" name="komentar">
        <trix-editor input="body"></trix-editor>
    </div>
    <button type="submit" class="btn btn-success float-end mx-1">Kirim</button>
    <a href="/riwayatpeminjaman" class="btn btn-primary float-end mx-1">Kembali</a>
</form>

@endsection