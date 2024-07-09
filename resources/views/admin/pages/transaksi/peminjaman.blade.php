@extends('admin.layouts.template')

@section('main')
<h1>Form Peminjaman</h1>

<form method="post" action="/admin/transaksi" enctype="multipart/form-data">
    @csrf
<div class="width-75">
  <div class="mb-3">
    <label for="kodebarang" class="form-label">Kode Barang</label>
    <input type="hidden" name="jenistransaksi" value="peminjaman">
    <input type="hidden" name="kodebarang" value="{{$data->pengajuanbarang->kodebarang}}">
    <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="kodebarang" name="kodebarang" value="{{$data->pengajuanbarang->kodebarang}}" disabled>
    @error('kodebarang')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
  <div class="mb-3">
    <label for="peminjam" class="form-label">Email Peminjam</label>
    <input type="hidden" name="peminjam" value="{{$data->userpeminjam->email}}">
    <input type="email" class="form-control @error('peminjam') is-invalid @enderror" id="peminjam" name="peminjam" value="{{$data->userpeminjam->email}}" disabled>
    @error('peminjam')<div class="invalid-feedback">{{$message}}</div>@enderror
  </div>
    <div class="mb-3">
      <label for="bataswaktu" class="form-label">Batas Waktu</label>
      <input type="datetime-local" class="form-control" id="datetime" name="bataswaktu">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
