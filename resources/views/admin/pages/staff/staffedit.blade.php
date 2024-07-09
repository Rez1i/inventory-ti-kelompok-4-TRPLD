@extends('admin.layouts.template')

@section('main')
<h1>Edit Data</h1>

<form method="post" action="/admin/staff/{{$staff->id}}" enctype="multipart/form-data">
@csrf
    @method('put')
    <div class="width-75">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{$staff->nama}}">
        </div>
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{$staff->nik}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$staff->email}}">
        </div>
        <div class="mb-3">
            <label for="no_telp" class="form-label">No Telp</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{$staff->no_telp}}">
        </div>
        <div class="mb-3">
            <label for="bagian_id" class="form-label">Bagian</label>
            <br>
            <select name="bagian_id" class="form-select text-secondary">
                <option value="-" class="form-control">Pilih Bagian</option>
                @foreach($data as $item)
                @if($item->id == $staff->bagian_id)
                <option value="{{ $item->id }}" selected>{{ $item->nama_bagian }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->nama_bagian }} </option>
                @endif
                @endforeach
                </select>
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