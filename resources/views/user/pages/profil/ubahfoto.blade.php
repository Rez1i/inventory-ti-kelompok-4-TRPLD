@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Ubah Foto</h2>
                    </div>
                    <div class="card m-1 p-4">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('Failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('Failed') }}
                            </div>
                        @endif
                        <form method="post" action="/ubahfoto" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <p>Pastikan file adalah jpeg,png,jpg</p>
                                <input class="form-control @error('foto')is-invalid @enderror" type="file" id="foto"
                                    name="foto" accept=".jpeg, .png, .jpg">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
                            <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
                        </form>


                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
