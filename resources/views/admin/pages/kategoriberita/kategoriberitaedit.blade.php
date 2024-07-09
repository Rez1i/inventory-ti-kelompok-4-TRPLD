@extends('admin.layouts.template')

@section('main')
    <h2>Update Data</h2>

    {{-- Display success or failure messages --}}
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
        </div>
    @endif

    {{-- Form to update category --}}
    <form method="post" action="/admin/kategoriberita/{{$kategoriberita->id}}">
        @csrf
        @method('put')

        <div class="width-75">
            {{-- Nama Kategori --}}
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategoriberita->nama_kategori) }}" required>
                @error('nama_kategori')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Keterangan (using Trix editor) --}}
            <div class="mb-3">
                <label for="body" class="form-label">Keterangan</label>
                <input id="body" type="hidden" name="keterangan" value="{{ old('keterangan', $kategoriberita->keterangan) }}">
                <trix-editor input="body" class="@error('keterangan') is-invalid @enderror"></trix-editor>
                @error('keterangan')
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
