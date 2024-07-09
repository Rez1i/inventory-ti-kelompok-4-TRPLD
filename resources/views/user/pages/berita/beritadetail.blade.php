@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="mt-4 mb-4 text-center">
                        <br>
                        <a href="/berita" class="btn-navbar">Kembali</a>
                    </div>
                    <div class="card m-1 p-4">
                        <div>
                            <h6 class="text-secondary float-end"><i>{{ $berita->userberita->username }} |
                                    {{ $berita->published }}</i></h6>
                            <br>
                            <br>
                            <h1>{{ $berita->judul }}</h1>
                            <br>
                            <img src="/storage/{{ $berita->gambar }}" alt="{{ $berita->judul }}"
                                class="img-fluid float-end m-3" style="max-width: 400px; height: auto;">
                            <div style="text-align: justify; text-indent: 50px;">
                                {!! $berita->isi_berita !!}
                            </div>

                        </div>


                        <h3 class="mt-5"><b>Komentar</b></h3>
                        <hr>

                        <div class="" style="width: auto;">
                            <ul class="list-group list-group-flush">

                                @if ($komentar->isEmpty())
                                    <p>Tidak ada komentar yang ditemukan.</p>
                                @else
                                    @foreach ($komentar as $item)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-1 ">
                                                    @if ($item->userkomentar->profile_photo == '-')
                                                        <img src="/storage/defaultfoto.png" alt="default"
                                                            class="rounded-circle" style="width:50px;height:50px;">
                                                    @else
                                                        <img src="/storage/{{ $item->userkomentar->profile_photo }}"
                                                            alt="foto" class="rounded-circle d-none d-md-block"
                                                            style="width:50px;height:50px;">
                                                    @endif
                                                </div>
                                                <div class="col-9">
                                                    <h6 class="m-0"><i>{{ $item->userkomentar->username }} |
                                                            {{ $item->created_at }}</i></h6>
                                                    <p class="m-0">{{ $item->isi_komentar }}</p>
                                                </div>
                                                <div class="col-2">
                                                    @if ($item->user_id == auth()->id() || auth()->user()->role == 'Admin')
                                                        <form action="/admin/komentarberita/{{ $item->id }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <span>
                                                                <button type="submit"
                                                                    class="btn btn-white text-secondary my-2 bg-none"
                                                                    onclick="return confirm('Yakin bos')"><b>Hapus</b></button>
                                                            </span>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="d-flex justify-content-end mt-4">
                                @if ($komentar->previousPageUrl())
                                    <a href="{{ $komentar->previousPageUrl() }}" class="btn btn-primary mx-1">&laquo;
                                        Previous</a>
                                @else
                                    <span class="btn btn-secondary disabled mx-1">&laquo; Previous</span>
                                @endif

                                @if ($komentar->nextPageUrl())
                                    <a href="{{ $komentar->nextPageUrl() }}" class="btn btn-primary mx-1">Next &raquo;</a>
                                @else
                                    <span class="btn btn-secondary disabled mx-1">Next &raquo;</span>
                                @endif
                            </div>
                        </div>

                        <form action="/admin/komentarberita" method="post">
                            @csrf
                            <div class="input-group my-5">

                                <input type="hidden" class="form-control @error('berita_id') is-invalid @enderror"
                                    value="{{ $berita->id }}" id="berita_id" name="berita_id"
                                    value="{{ old('berita_id') }}">
                                @error('berita_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control @error('isi_komentar') is-invalid @enderror"
                                    placeholder="Comments" id="isi_komentar" name="isi_komentar"
                                    value="{{ old('isi_komentar') }}">
                                @error('isi_komentar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary" id="button-addon2">Send</button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
