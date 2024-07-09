@extends('admin.layouts.template')

@section('main')
@include('admin.pages.transaksi.cardnavigasitransaksi')
    <h2>Data Mutasi Barang</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <div class="">
        <a href="/admin/mutasibarang/create" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto" >Create</a>
    </div> 
    <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
    <div class="table-responsive">
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Penanggung Jawab</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->penanggungjawab}}</td> 
        <td>{{ $item->status }}</td> 
        <td>
        <form action="/admin/mutasibarang/{{ $item->id }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
         </form>
         @if($item->laporan != '-')
            <a href="/admin/downloadlaporanmutasi/{{$item->id }}" class="btn btn-warning">Laporan</a>
          @else
          <a href="#" class="btn btn-warning disabled" >Laporan</a>
          @endif
          
          <a href="/admin/barangmutasi/{{$item->id }}" class="btn btn-warning">Detail</a>
        </td>
    </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection
