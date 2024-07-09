@extends('admin.layouts.template')

@section('main')
<h1>Create New Data</h1>

<form method="post" action="/admin/staff" enctype="multipart/form-data">
    @csrf
<div class="width-75">
  <div class="mb-3">
    <label for="nama" class="form-label">Nama Staff</label>
    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{old('nama')}}">
    @error('nama')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="nik" class="form-label">NIK</label>
    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{old('nik')}}">
    @error('nik')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}">
    @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="no_telp" class="form-label">No Telp</label>
    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{old('no_telp')}}">
    @error('no_telp')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
    <div class="mb-3">
            <label for="bagian_id" class="form-label">Bagian Kerja</label>
            <br>
                <select name="bagian_id" class="form-select text-secondary">
                    <option value="-" class="form-control">Pilih Bagian</option>
                    @foreach($data as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_bagian }}</option>
                    @endforeach
                </select>
        </div>
  <div class="mb-3">
        <label for="foto" class="form-label">Pastikan file adalah jpeg,png,jpg</label>
        <input class="form-control" type="file" id="foto" name="foto" accept=".jpeg, .png, .jpg" value="{{old('foto')}}">
  </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
