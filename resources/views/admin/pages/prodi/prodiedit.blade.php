@extends('admin.layouts.template')

@section('main')
<h1>Update Data</h1>

<form method="post" action="/admin/prodi/{{$prodi->id}}">
    @csrf
    @method('put')
    <div class="width-75">
    <div class="mb-3">
        <label for="nama_prodi" class="form-label">Nama Program Studi</label>
        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="{{$prodi->nama_prodi}}">
    </div>
    <div class="mb-3">
        <label for="singkatan" class="form-label">Singkatan Nama</label>
        <input type="text" class="form-control" id="singkatan" name="singkatan" value="{{$prodi->singkatan}}">
    </div>
    <div class="mb-3">
        <label for="jenjangstudi" class="form-label">Jenjang Studi</label>
        <select name="jenjangstudi" id="jenjang stud" class="form-select">
            @if($prodi->jenjangstudi == "D4")
                <option value="-">Pilih</option>
                <option value="D4" selected>Sarjana Terapan</option>
                <option value="D3">Diploma</option>
            @elseif($prodi->jenjangstudi == "D3")
                <option value="-">Pilih</option>
                <option value="D4" >Sarjana Terapan</option>
                <option value="D3" selected>Diploma</option>
            @else
                <option value="-" selected>Pilih</option>
                <option value="D4" >Sarjana Terapan</option>
                <option value="D3">Diploma</option>
            @endif
        </select>
    </div>
    <div class="mb-3">
        <label for="akreditasi" class="form-label">Akreditasi</label>
        <input type="text" class="form-control" id="akreditasi" name="akreditasi" value="{{$prodi->akreditasi}}">
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Ketua Program Studi</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{$prodi->nama}}">
    </div>
    <div class="mb-3">
        <label for="tahunberdiri" class="form-label">Tahun Berdiri</label>
        <input type="text" class="form-control" id="tahunberdiri" name="tahunberdiri" value="{{$prodi->tahunberdiri}}">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection