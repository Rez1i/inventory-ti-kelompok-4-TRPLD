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
<form method="post" action="/ubahfoto" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <p>Pastikan file adalah jpeg,png,jpg</p>
            <input class="form-control @error('foto')is-invalid @enderror" type="file" id="foto" name="foto" accept=".jpeg, .png, .jpg">
            @error('foto')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>
    <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
    <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
</form>

@endsection
