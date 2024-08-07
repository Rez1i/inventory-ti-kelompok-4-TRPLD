@extends('layouts.template')

@section('main')
    <main>
        <!-- Banner Start -->
        <div class="container-fluid py-5 my-4" style="background: linear-gradient(135deg, #ffd752, #ffa552);">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7">
                        <h1 class="mb-4">Selamat Datang</h1>
                        <h1 class="mb-4">Sistem Informasi Inventaris Barang Labor TI</h1>
                        <p class="text-dark mb-4 pb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                            an unknown printer took a galley
                        </p>
                        <div class="position-relative mx-auto">
                            <input class="form-control w-100 py-3 rounded-pill" type="email"
                                placeholder="Your Busines Email">
                            <button type="submit"
                                class="btn btn-primary py-3 px-5 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 0;">Subscribe Now</button>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="rounded">
                            <img src="img/siibala-icon-light.png" class="img-fluid rounded w-100 rounded" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->
    </main>
@endsection
