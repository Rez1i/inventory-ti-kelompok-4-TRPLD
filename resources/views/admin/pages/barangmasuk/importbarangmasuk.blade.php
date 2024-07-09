@extends('admin.layouts.template')

@section('main')
    <h4>Note!!</h4>
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
    {{-- Form untuk upload file --}}
    <form action="/admin/barangmasuk/import" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            {{-- Informasi penggunaan file --}}
            <p>
                Pastikan File yang ingin anda upload tersusun seperti
                <a href="/admin/contohfilebarangmasuk"><b>Contoh File</b></a>.
                Pastikan juga kode barang yang anda tambahkan berbeda dengan kode barang lainnya.
                Untuk jenis barang dan kategori barang harus sudah terdaftar di dalam sistem.
                Data yang dituliskan "none" dalam contoh file berarti abaikan data tersebut dan cukup ditulis none saja.
                Pastikan semua syarat terpenuhi, jika tidak data tidak akan ditambahkan ke database.
            </p>
            <p>Pastikan file adalah file .xlsx, .xls, atau .csv</p>

            {{-- Input file --}}
            <input class="form-control @error('file') is-invalid @enderror" type="file" id="formFile" name="file" accept=".xlsx, .xls, .csv">
            @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- Hidden input untuk menyimpan barangmasuk_id --}}
            <input type="hidden" name="barangmasuk_id" id="id" value="{{ $id }}">
        </div>

        {{-- Tombol submit --}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
