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
    <form method="post" action="/admin/satuan">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="nama_satuan" class="form-label">Nama Satuan Barang</label>
                <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror" id="nama_satuan" name="nama_satuan" required>
                @error('nama_satuan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input id="body" type="hidden" name="keterangan">
                <trix-editor input="body"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
