@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Ubah Password</h2>
                    </div>
                    <div class="card m-1 p-4">
                        <form method="post" action="/ubahpassword">
                            @csrf
                            <div class="width-75">
                                <div class="mb-3">
                                    <label for="passwordlama" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="passwordlama" name="passwordlama">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-success float-end mx-1">Ubah</button>
                                <a href="/editprofile" class="btn btn-primary float-end mx-1">Kembali</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
