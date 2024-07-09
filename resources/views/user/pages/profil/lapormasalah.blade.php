@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Laporkan Masalah</h2>
                    </div>
                    <div class="card m-1 p-4">
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
                                    <p>Jika anda menemukan masalah atau bug pada sistem ini, kami mohon agar anda mau
                                        mengirimkan laporan agar kami bisa mengatasinya.</p>
                                    <input id="body" type="hidden" name="laporan">
                                    <trix-editor input="body"></trix-editor>
                                </div>
                                <button type="submit" class="btn btn-success float-end mx-1">Kirim</button>
                                <a href="/adminuser" class="btn btn-primary float-end mx-1">Kembali</a>
                        </form>


                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
