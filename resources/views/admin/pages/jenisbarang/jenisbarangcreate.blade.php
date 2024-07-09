@extends('admin.layouts.template')

@section('main')
    <h2>Create New Data</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <form method="post" action="/admin/jenisbarang" enctype="multipart/form-data">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="nama_jenisbarang" class="form-label">Jenis Barang</label>
                <input type="text" class="form-control @error('nama_jenisbarang') is-invalid @enderror" id="nama_jenisbarang" name="nama_jenisbarang" required>
                @error('nama_jenisbarang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kategoribarang_id" class="form-label">Kategori Barang</label>
                <select name="kategoribarang_id" class="form-select text-secondary @error('kategoribarang_id') is-invalid @enderror" required>
                    <option value="-">Pilih Kategori</option>
                    @foreach($data as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kategoribarang }}</option>
                    @endforeach
                </select>
                @error('kategoribarang_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
