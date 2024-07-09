@extends('admin.layouts.template')

@section('main')
    <h2>Create New Data</h2>

    {{-- Display success or failure messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    {{-- Form to create new data --}}
    <form method="post" action="/admin/barangmasuk" enctype="multipart/form-data">
        @csrf

        <div class="width-75">
            {{-- Hidden input for barangmasuk_id --}}
            <input type="hidden" id="barangmasuk_id" name="barangmasuk_id" value="{{ $barangmasuk->id }}">

            {{-- Kode Barang --}}
            <div class="mb-3">
                <label for="kodebarang" class="form-label">Kode Barang</label>
                <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="kodebarang"
                    name="kodebarang" value="{{ old('kodebarang') }}" required>
                @error('kodebarang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Nama Barang --}}
            <div class="mb-3">
                <label for="namabarang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('namabarang') is-invalid @enderror" id="namabarang"
                    name="namabarang" value="{{ old('namabarang') }}" required>
                @error('namabarang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Jenis Barang --}}
            <div class="mb-3">
                <label for="jenisbarang_id" class="form-label">Jenis Barang</label>
                <select name="jenisbarang_id"
                    class="form-select text-secondary @error('jenisbarang_id') is-invalid @enderror" required>
                    <option value="-">Pilih jenis barang</option>
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_jenisbarang }}</option>
                    @endforeach
                </select>
                @error('jenisbarang_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Satuan Barang --}}
            <div class="mb-3">
                <label for="satuan_id" class="form-label">Satuan Barang</label>
                <select name="satuan_id" class="form-select text-secondary @error('satuan_id') is-invalid @enderror"
                    required>
                    <option value="-">Pilih satuan barang</option>
                    @foreach ($satuan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_satuan }}</option>
                    @endforeach
                </select>
                @error('satuan_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Kondisi Barang --}}
            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Barang</label>
                <select name="kondisi" class="form-select text-secondary @error('kondisi') is-invalid @enderror" required>
                    <option value="-">Pilih kondisi barang</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
                @error('kondisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Tahun Pengadaan --}}
            <div class="mb-3">
                <label for="tahunpengadaan" class="form-label">Tahun Pengadaan</label>
                <input type="text" class="form-control @error('tahunpengadaan') is-invalid @enderror" id="tahunpengadaan"
                    name="tahunpengadaan" value="{{ $barangmasuk->tahunpengadaan }}" disabled>
                <input type="hidden" name="tahunpengadaan" value="{{ $barangmasuk->tahunpengadaan }}">
                @error('tahunpengadaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Stock (default value 1) --}}
            <input type="hidden" name="stock" value="1">

            {{-- Foto --}}
            <div class="mb-3">
                <label for="foto" class="form-label">Foto (jpeg, png, jpg)</label>
                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto"
                    accept=".jpeg, .png, .jpg">
                @error('foto')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
