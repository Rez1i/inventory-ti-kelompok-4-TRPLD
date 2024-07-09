@extends('user.layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <section class="page-section" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container-fluid py-5 mt-5">
                <div class="container">
                    <div class="text-center">
                        <h2 class="welcome-title mb-4">Ubah Username</h2>
                    </div>
                    <div class="card m-1 p-4">
                        <form method="post" action="/ubahusername">
                            @csrf
                            <div class="width-75">
                                <div class="mb-3">
                                    <label for="usernamelama" class="form-label">Username Sebelumnya</label>
                                    <input type="text" class="form-control" id="usernamelama" name="usernamelama"
                                        value="@auth {{ auth()->user()->username }} @endauth" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="usernamebaru" class="form-label">Username Baru</label>
                                    <input type="text" class="form-control" id="usernamebaru" name="usernamebaru">
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
