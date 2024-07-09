@extends('admin.layouts.template')

@section('main')
    <h2>Form Pengembalian</h2>
    
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <form method="post" action="/admin/transaksi" enctype="multipart/form-data">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="kodebarang" class="form-label">Kode Barang</label>
                <input type="hidden" name="jenistransaksi" value="pengembalian">
                <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="kodebarang" name="kodebarang" value="{{ old('kodebarang') }}" required>
                @error('kodebarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="peminjam" class="form-label">Email Peminjam</label>
                <input type="text" class="form-control @error('peminjam') is-invalid @enderror" id="peminjam" name="peminjam" value="{{ old('peminjam') }}" required>
                @error('peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
