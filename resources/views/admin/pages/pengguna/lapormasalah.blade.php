@extends('admin.layouts.template')

@section('main')
    <form method="post" action="/laporkanmasalah">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="laporan" class="form-label">Kirim Laporan</label>
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif(session()->has('Failed'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('Failed') }}
                    </div>
                @endif
                <p>Jika anda menemukan masalah atau bug pada sistem ini, kami mohon agar anda mau mengirimkan laporan agar
                    kami bisa mengatasinya.</p>
                <input id="body" type="hidden" name="laporan">
                <trix-editor input="body"></trix-editor>
            </div>
            <button type="submit" class="btn btn-success float-end mx-1">Kirim</button>
            <a href="/admin" class="btn btn-primary float-end mx-1">Kembali</a>
    </form>
@endsection
