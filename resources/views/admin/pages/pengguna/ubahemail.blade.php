@extends('admin.layouts.template')

@section('main')
<form method="post" action="/ubahemail">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="emaillama" class="form-label">Email Sebelumnya</label>
        <input type="email" class="form-control" id="emaillama" name="emaillama" value="@auth {{auth()->user()->email}} @endauth" disabled>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email Baru</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
    <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
</form>

@endsection