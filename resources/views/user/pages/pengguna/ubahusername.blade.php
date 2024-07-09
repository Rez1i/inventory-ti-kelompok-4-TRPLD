@extends('admin.layouts.template')

@section('main')
<form method="post" action="/ubahusername">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="usernamelama" class="form-label">Username Sebelumnya</label>
        <input type="text" class="form-control" id="usernamelama" name="usernamelama" value="@auth {{auth()->user()->username}} @endauth" disabled>
    </div>
    <div class="mb-3">
        <label for="usernamebaru" class="form-label">Username Baru</label>
        <input type="text" class="form-control" id="usernamebaru" name="usernamebaru">
    </div>
    <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
    <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
</form>

@endsection