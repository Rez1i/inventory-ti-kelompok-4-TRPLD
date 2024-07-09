@extends('admin.layouts.template')

@section('main')
    <h2>Create New Data</h2>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form method="post" action="/admin/barangmasuk" enctype="multipart/form-data">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="pemasok" class="form-label">Vendor</label>
                <input type="text" class="form-control @error('pemasok') is-invalid @enderror" id="pemasok"
                    name="pemasok" value="{{ old('pemasok') }}" required>
                @error('pemasok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tahunpengadaan" class="form-label">Tahun Pengadaan</label>
                <br>
                <select name="tahunpengadaan" id="tahunpengadaan"
                    class="form-select text-secondary @error('tahunpengadaan') is-invalid @enderror" required>
                    <option value="">-</option>
                    @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
                        <option value="{{ $tahun }}" {{ old('tahunpengadaan') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}</option>
                    @endfor
                </select>
                @error('tahunpengadaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="laporan" class="form-label">Berkas Laporan</label>
                <p>Pastikan file adalah PDF</p>
                <input class="form-control @error('laporan') is-invalid @enderror" type="file" id="laporan"
                    name="laporan" accept=".pdf">
                @error('laporan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
