@extends('admin.layouts.template')

@section('main')
<h2>Program Studi Baru</h2>
<form method="post" action="/admin/prodi">
    @csrf
    <div class="width-75">
    <div class="mb-3">
        <label for="nama_prodi" class="form-label">Nama Program Studi</label>
        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi">
    </div>
    <div class="mb-3">
        <label for="singkatan" class="form-label">Singkatan Nama</label>
        <input type="text" class="form-control" id="singkatan" name="singkatan">
    </div>
    <div class="mb-3">
        <label for="jenjangstudi" class="form-label">Jenjang Studi</label>
        <select name="jenjangstudi" id="jenjang stud" class="form-select">
            <option value="-">Pilih</option>
            <option value="D4">Sarjana Terapan</option>
            <option value="D3">Diploma</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="akreditasi" class="form-label">Akreditasi</label>
        <input type="text" class="form-control" id="akreditasi" name="akreditasi">
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Ketua Program Studi</label>
        <input type="text" class="form-control" id="nama" name="nama">
    </div>
    <div class="mb-3">
        <label for="tahunberdiri" class="form-label">Tahun Berdiri</label>
        <input type="text" class="form-control" id="tahunberdiri" name="tahunberdiri">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection