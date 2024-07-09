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

    <form method="post" action="/admin/barang/{{$barang->id}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="kodebarang" class="form-label">Kode Barang</label>
                <input type="text" class="form-control" id="kodebarang" name="kodebarang" value="{{$barang->kodebarang}}" disabled>
                <input type="hidden" name="kodebarang" value="{{$barang->kodebarang}}">
            </div>
            <div class="mb-3">
                <label for="namabarang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('namabarang') is-invalid @enderror" id="namabarang" name="namabarang" value="{{ old('namabarang', $barang->namabarang) }}" required>
                @error('namabarang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenisbarang_id" class="form-label">Jenis Barang</label>
                <select name="jenisbarang_id" class="form-select text-secondary @error('jenisbarang_id') is-invalid @enderror" required>
                    <option value="">Pilih Jenis Barang</option>
                    @foreach($data as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $barang->jenisbarang_id ? 'selected' : '' }}>{{ $item->nama_jenisbarang }}</option>
                    @endforeach
                </select>
                @error('jenisbarang_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="satuan_id" class="form-label">Satuan Barang</label>
                <select name="satuan_id" class="form-select text-secondary @error('satuan_id') is-invalid @enderror" required>
                    <option value="">Pilih Satuan Barang</option>
                    @foreach($satuan as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $barang->satuan_id ? 'selected' : '' }}>{{ $item->nama_satuan }}</option>
                    @endforeach
                </select>
                @error('satuan_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <p>Pastikan file adalah jpeg, png, jpg</p>
                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" accept=".jpeg, .png, .jpg">
                @error('foto')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
