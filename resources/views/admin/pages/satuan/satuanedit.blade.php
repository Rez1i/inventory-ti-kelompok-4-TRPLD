@extends('admin.layouts.template')

@section('main')
    <h2>Update Data</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form method="post" action="/admin/satuan/{{$satuan->id}}">
        @csrf
        @method('put')
        <div class="width-75">
            <div class="mb-3">
                <label for="nama_satuan" class="form-label">Nama Satuan</label>
                <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror" id="nama_satuan" name="nama_satuan" value="{{ old('nama_satuan', $satuan->nama_satuan) }}" required>
                @error('nama_satuan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input id="keterangan" type="hidden" name="keterangan" value="{{ $satuan->keterangan }}">
                <trix-editor input="keterangan"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script>
        document.addEventListener('trix-file-accept', function(event) {
            event.preventDefault();
            alert('Upload file tidak diizinkan.');
        });
    </script>
@endsection
