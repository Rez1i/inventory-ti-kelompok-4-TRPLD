@extends('admin.layouts.template')

@section('main')
<h1>Comments</h1>
<hr>
@if($komentar->isEmpty())
    <p>Tidak ada komentar yang ditemukan.</p>
@else
<div class="card" style="width: 50rem;">
    <ul class="list-group list-group-flush">
    @foreach($komentar as $item)
         <li class="list-group-item">
         <div class="row align-items-center">
            <div class="col-auto">
                @if($item->userkomentar->profile_photo == "-")
                    <img src="/storage/defaultfoto.png" alt="default" class="rounded-circle" style="width:50px;height:50px;">
                @else
                    <img src="/storage/{{$item->userkomentar->profile_photo}}" alt="foto" class="rounded-circle"  style="width:50px;height:50px;">
                @endif
            </div>
            <div class="col-8">
                <h6 class="m-0"><i>{{$item->userkomentar->username}}</i></h6>
                <p class="m-0">{{$item->isi_komentar}}</p>
            </div>
            <div class="col">
                    <a href="" class="btn btn-danger m-0">Hapus</a>
                    <a href="" class="btn btn-primary m-0">Edit</a>
            </div>
        </div> 
        </li>  
    @endforeach
    </ul>
</div>   
@endif
        <div class="row align-items-center my-3">
            <div class="col-10">
                <input type="text" class="form-control @error('tambahkomentar') is-invalid @enderror" placeholder="Comments" id="tambahkomentar" name="tambahkomentar" value="{{ old('tambahkomentar') }}">
                @error('tambahkomentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>

            </div>
            
        </div> 



@endsection