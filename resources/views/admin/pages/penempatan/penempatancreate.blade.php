@extends('admin.layouts.template')

@section('main')
<h1>Create New Data</h1>

<form method="post" action="/admin/penempatan">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="kodebarang" class="form-label">Kode Barang</label>
        <input type="text" class="form-control" id="kodebarang" name="kodebarang">
    </div>
    <div class="mb-3">
    <label for="ruangan_id" class="form-label">Ruangan</label>
    <br>
        <select name="ruangan_id" class="form-select text-secondary">
            <option value="-" class="form-control">Pilih Ruangan</option>
            @foreach($data as $item)
            <option value="{{ $item->id }}">{{ $item->nama_ruangan }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection