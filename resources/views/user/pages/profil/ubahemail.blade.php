@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Ubah Email</h2>
                    </div>
                    <div class="card m-1 p-4">
                        <form method="post" action="/ubahemail">
                            @csrf
                            <div class="width-75">
                                <div class="mb-3">
                                    <label for="emaillama" class="form-label">Email Sebelumnya</label>
                                    <input type="email" class="form-control" id="emaillama" name="emaillama"
                                        value="@auth {{ auth()->user()->email }} @endauth" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Baru</label>
                                    <input type="email" class="form-control" id="email" name="email">
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
