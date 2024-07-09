@extends('admin.layouts.template')

@section('main')
    <h2>Update Data</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <form method="post" action="/admin/kategoribarang/{{$kategoribarang->id}}">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="nama_kategoribarang" class="form-label">Nama Kategori Barang</label>
                <input type="text" class="form-control @error('nama_kategoribarang') is-invalid @enderror" id="nama_kategoribarang" name="nama_kategoribarang" value="{{ old('nama_kategoribarang', $kategoribarang->nama_kategoribarang) }}" required>
                @error('nama_kategoribarang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input id="body" type="hidden" name="keterangan" value="{{ old('keterangan', $kategoribarang->keterangan) }}">
                <trix-editor input="body"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
