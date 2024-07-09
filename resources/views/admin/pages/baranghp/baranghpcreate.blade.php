@extends('admin.layouts.template')

@section('main')
<h1>Create New Data</h1>

<form method="post" action="/admin/baranghp" enctype="multipart/form-data">
    @csrf
<div class="width-75">
  <div class="mb-3">
    <label for="kodebarang" class="form-label">Kode Barang</label>
    <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="kodebarang" name="kodebarang" value="{{old('kodebarang')}}">
    @error('kodebarang')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="namabarang" class="form-label">Nama Barang</label>
    <input type="text" class="form-control @error('namabarang') is-invalid @enderror" id="namabarang" name="namabarang" value="{{old('namabarang')}}">
    @error('namabarang')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="kategoribarang_id" class="form-label">Kategori Barang</label>
        <br>
        <select name="kategoribarang_id" class="form-select text-secondary">
                <option value="-" class="form-control">-</option>
                @foreach($data as $item)
                <option value="{{ $item->id }}">{{ $item->nama_kategoribarang }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
    <label for="tahunpengadaan" class="form-label">Tahun Pengadaan</label>
        <br>
        <select name="tahunpengadaan" id="tahunpengadaan" class="form-select text-secondary">
        @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
            <option value="{{ $tahun }}">{{ $tahun }}</option>
        @endfor
        </select>
    </div>
    <div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{old('stock')}}">
        @error('stock')<div class="invalid-feedback">{{$message}}</div>@enderror
    </div>
    <div class="mb-3">
    <label for="satuan_id" class="form-label">Satuan Barang</label>
        <br>
        <select name="satuan_id" class="form-select text-secondary">
                <option value="-" class="form-control">Satuan Barang</option>
                @foreach($satuan as $item)
                <option value="{{ $item->id }}">{{ $item->nama_satuan }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Pastikan file adalah jpeg,png,jpg</label>
        <input class="form-control" type="file" id="foto" name="foto" accept=".jpeg, .png, .jpg" value="{{old('foto')}}">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
