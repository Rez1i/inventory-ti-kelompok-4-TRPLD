@extends('admin.layouts.template')

@section('main')
<h1>Edit Data</h1>

<form method="post" action="/admin/baranghp/{{$baranghp->id}}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="width-75">
        <div class="mb-3">
            <label for="kodebarang" class="form-label">Kode Barang</label>
            <input type="hidden" class="form-control" id="kodebarang" name="kodebarang" value="{{$baranghp->kodebarang}}">
            <input type="text" class="form-control" id="kodebarang" name="kodebarang" value="{{$baranghp->kodebarang}}"disabled>
        </div>
        <div class="mb-3">
            <label for="namabarang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="namabarang" name="namabarang" value="{{$baranghp->namabarang}}">
        </div>
        <div class="mb-3">
            <label for="kategoribarang_id" class="form-label">Kategori Barang</label>
            <br>
            <select name="kategoribarang_id" class="form-select text-secondary">
                <option value="-" class="form-control">-</option>
                @foreach($data as $item)
                @if($item->id == $baranghp->kategoribarang_id)
                <option value="{{ $item->id }}" selected>{{ $item->nama_kategoribarang }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->nama_kategoribarang }} </option>
                @endif
                @endforeach
                </select>
        </div>
        <div class="mb-3">
            <label for="satuan_id" class="form-label">Satuan Barang</label>
            <br>
            <select name="satuan_id" class="form-select text-secondary">
                <option value="-" class="form-control">Satuan Barang</option>
                @foreach($satuan as $item)
                @if($item->id == $baranghp->satuan_id)
                <option value="{{ $item->id }}" selected>{{ $item->nama_satuan }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->nama_satuan }} </option>
                @endif
                @endforeach
                </select>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{$baranghp->stock}}">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <p>Pastikan file adalah jpeg,png,jpg</p>
            <input class="form-control" type="file" id="foto" name="foto" accept=".jpeg, .png, .jpg">
        </div>
    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection