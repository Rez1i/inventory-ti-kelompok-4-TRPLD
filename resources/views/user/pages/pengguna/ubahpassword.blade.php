@extends('admin.layouts.template')

@section('main')
<form method="post" action="/ubahpassword">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="passwordlama" class="form-label">Password Lama</label>
        <input type="password" class="form-control" id="passwordlama" name="passwordlama">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
    <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
    </div>
</form>

@endsection