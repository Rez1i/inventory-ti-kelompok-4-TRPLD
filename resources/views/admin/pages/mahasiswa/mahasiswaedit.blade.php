@extends('admin.layouts.template')

@section('main')
    <h1>Edit Data</h1>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <form method="post" action="/admin/mahasiswa/{{$mahasiswa->id}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                       value="{{ $mahasiswa->nama }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim"
                       value="{{ $mahasiswa->nim }}" required>
                @error('nim')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ $mahasiswa->email }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="prodi_id" class="form-label">Program Studi</label>
                <br>
                <select name="prodi_id" class="form-select text-secondary @error('prodi_id') is-invalid @enderror"
                        required>
                    <option value="-" class="form-control">Pilih Prodi</option>
                    @foreach($data as $item)
                        <option value="{{ $item->id }}" @if($item->id == $mahasiswa->prodi_id) selected @endif>{{ $item->nama_prodi }}</option>
                    @endforeach
                </select>
                @error('prodi_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                       name="no_telp" value="{{ $mahasiswa->no_telp }}" required>
                @error('no_telp')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <p>Pastikan file adalah jpeg, png, jpg</p>
                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto"
                       accept=".jpeg, .png, .jpg">
                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
