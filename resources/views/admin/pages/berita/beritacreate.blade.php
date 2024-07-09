@extends('admin.layouts.template')

@section('main')
    <h2>Create New Data</h2>

    {{-- Display success or failure messages --}}
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    {{-- Form to create new news --}}
    <form method="post" action="/admin/berita" enctype="multipart/form-data">
        @csrf

        <div class="width-75">
            {{-- Judul --}}
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select text-secondary @error('kategori_id') is-invalid @enderror" required>
                    <option value="-" disabled selected>Pilih kategori</option>
                    @foreach($data as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Isi Berita (using Trix editor) --}}
            <div class="mb-3">
                <label for="body" class="form-label">Isi Berita</label>
                <input id="body" type="hidden" name="isi_berita" value="{{ old('isi_berita') }}">
                <trix-editor input="body" class="@error('isi_berita') is-invalid @enderror"></trix-editor>
                @error('isi_berita')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Gambar --}}
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <p>Pastikan file adalah jpeg, png, jpg</p>
                <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept=".jpeg, .png, .jpg" required>
                @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
