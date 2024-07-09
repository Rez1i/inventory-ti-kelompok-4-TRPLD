@extends('admin.layouts.template')

@section('main')
    <h2>Edit Data</h2>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <form method="post" action="/admin/barangkeluar/{{$barangkeluar->id}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="penerima" class="form-label">Email Penerima</label>
                <input type="text" class="form-control @error('penerima') is-invalid @enderror" id="penerima" name="penerima" value="{{ old('penerima', $barangkeluar->penerima) }}" required>
                @error('penerima')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="kodebarang" class="form-label">Kode Barang</label>
                <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="kodebarang" name="kodebarang" value="{{ old('kodebarang', $barangkeluar->barang_keluar->kodebarang) }}" required>
                @error('kodebarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="banyakbarang" class="form-label">Banyak Barang</label>
                <input type="text" class="form-control @error('banyakbarang') is-invalid @enderror" id="banyakbarang" name="banyakbarang" value="{{ old('banyakbarang', $barangkeluar->banyakbarang) }}" required>
                @error('banyakbarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan</label>
                <input id="tujuan" type="hidden" name="tujuan" value="{{ old('tujuan', $barangkeluar->tujuan) }}">
                <trix-editor input="tujuan"></trix-editor>
                @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
