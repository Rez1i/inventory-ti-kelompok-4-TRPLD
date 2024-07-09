@extends('admin.layouts.template')

@section('main')
<div class="card-header text-bold">
    <h2>Balas Saran Atau Komentar</h2>
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session()->has('Failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('Failed') }}
                </div>
        @endif
</div>
<div class="card-body">
<form method="post" action="/laporkanmasalah/{{$masalah->id}}">
    @csrf
    @method('put')
    <div class="width-75">
       <div class="mb-3">
        <input type="hidden" name="laporandanmasukan" value="{{$masalah->laporandanmasukan}}">
        <input type="hidden" name="user_id" value="{{$masalah->user_id}}">
            <label for="laporandanmasukan" class="form-label">Saran dan Komentar</label>
            <p name="laporandanmasukan">{{$masalah->laporandanmasukan}}</p>
       </div>
        <div class="mb-3">
            <label for="tanggapan" class="form-label">Tanggapan</label>
            <input id="body" type="hidden" name="tanggapan">
            <trix-editor input="body"></trix-editor>
        </div>
    </div>   
    <button type="submit" class="btn btn-success float-end mx-1">Kirim</button>
    <a href="/admin" class="btn btn-primary float-end mx-1">Kembali</a>
</form>

</div>


@endsection