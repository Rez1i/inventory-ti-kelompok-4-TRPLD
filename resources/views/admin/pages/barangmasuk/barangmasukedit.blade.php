@extends('admin.layouts.template')

@section('main')
    <h2>Edit Data</h2>

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

    {{-- Form to edit data --}}
    <form method="post" action="/admin/barangmasuk/{{$barangmasuk->id}}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="width-75">
            {{-- Pemasok --}}
            <div class="mb-3">
                <label for="pemasok" class="form-label">Pemasok</label>
                <input type="text" class="form-control @error('pemasok') is-invalid @enderror" id="pemasok" name="pemasok" value="{{ $barangmasuk->pemasok }}" required>
                @error('pemasok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Tahun Pengadaan --}}
            <div class="mb-3">
                <label for="tahunpengadaan" class="form-label">Tahun Pengadaan</label>
                <select name="tahunpengadaan" id="tahunpengadaan" class="form-select text-secondary @error('tahunpengadaan') is-invalid @enderror" required>
                    @for ($tahun = date('Y'); $tahun >= 1900; $tahun--)
                        <option value="{{ $tahun }}" @if($barangmasuk->tahunpengadaan == $tahun) selected @endif>{{ $tahun }}</option>
                    @endfor
                </select>
                @error('tahunpengadaan')
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
