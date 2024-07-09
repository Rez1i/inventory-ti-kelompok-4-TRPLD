@extends('admin.layouts.template')

@section('main')
    <h3 class="mb-3"><b>Berita Terbaru</b></h3>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
        </div>
        @endif
        <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->

        <div class="row">
        @foreach($beritaterbaru->take(3) as $item)
            <div class="col-lg-4 m-0 p-2">
                <div class="card border-3 shadow" style="width: 100%; height: 26rem;">
                    <img src="/storage/{{$item->gambar}}" class="card-img-top" alt="..." style="width:100%;height:170px;">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->judul}}</h5>
                        <p class="card-text">{{$item->isi_berita}} <a href="/admin/beritadetail/{{ $item->id }}" class="link">Selengkapnya</a></p>
                        
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <h3 class="my-3"><b>Berita Lainnya</b></h3>
        <section>
        @foreach($beritalainnya as $item)
            <div class="card mb-3 border-3 shadow" style="width: 100%; height:100%;">
                <div class="row g-0">
                    <div class="col-md-4 align-items-center">
                        <img src="/storage/{{ $item->gambar }}" class="card-img img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">{!! Str::limit($item->isi_berita, 200, '...') !!} <a href="/admin/beritadetail/{{ $item->id }}" class="link">Selengkapnya</a></p>
                            <p class="card-text"><small class="text-body-secondary">{{ $item->updated_at }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>   

    <div class="d-flex justify-content-end mt-4">
        @if ($beritalainnya->previousPageUrl())
            <a href="{{ $beritalainnya->previousPageUrl() }}" class="btn btn-primary mx-1">&laquo; Previous</a>
        @else
            <span class="btn btn-secondary disabled mx-1">&laquo; Previous</span>
        @endif

        @if ($beritalainnya->nextPageUrl())
            <a href="{{ $beritalainnya->nextPageUrl() }}" class="btn btn-primary mx-1">Next &raquo;</a>
        @else
            <span class="btn btn-secondary disabled mx-1">Next &raquo;</span>
        @endif
    </div>



                    
               
@endsection
