@extends('admin.layouts.template')

@section('main')
<h2>Create New Data</h2>
@if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

<form method="post" action="/admin/mutasibarang" enctype="multipart/form-data">
    @csrf
    <div class="width-75">
        <div class="mb-3">
            <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
            <input type="hidden" name="inputan" value="databarangmutasi">
            <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror" id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}" required>
            @error('penanggungjawab')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="alasan" class="form-label">Alasan</label>
            <input id="body" type="hidden" name="alasan">
            <trix-editor input="body"></trix-editor>
            @error('alasan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="laporan" class="form-label">Berkas Laporan</label>
            <p>Pastikan file adalah PDF</p>
            <input class="form-control @error('laporan') is-invalid @enderror" type="file" id="laporan" name="laporan" accept=".pdf" required>
            @error('laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary float-end">Lanjut</button>
</form>

@endsection
