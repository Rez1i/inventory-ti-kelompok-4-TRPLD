@extends('admin.layouts.template')

@section('main')
<h1>Update Data</h1>

<form method="post" action="/admin/penempatan/{{$penempatan->id}}">
    @csrf
    @method('put')
    <div class="width-75">
    <div class="mb-3">
        <label for="kodebarang" class="form-label">Kode Barang</label>
        <input type="text" class="form-control" id="kodebarang" name="kodebarang" value="{{$penempatan->kodebarang}}">
    </div>
    <div class="mb-3">
        <label for="ruangan_id" class="form-label">Ruangan</label>
        <br>
        <select name="ruangan_id" class="form-select text-secondary">
            <option value="-" class="form-control">Pilih Ruangan</option>
            @foreach($data as $item)
                <option value="{{ $item->id }}" @if($item->id == $penempatan->ruangan_id) selected @endif>{{ $item->nama_ruangan }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
    <label for="alasan" class="form-label">Alasan</label>
        <input id="body" type="hidden" name="alasan">
        <trix-editor input="body"></trix-editor>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection