@extends('admin.layouts.template')

@section('main')
    <h1>Data Mutasi Barang</h1>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <p>Penanggung Jawab : {{$mutasibarang->penanggungjawab}}</p>
    <p>Banyak Barang : {{$mutasibarang->banyakbarang}}</p>
    <p>Tambah Barang : </p>
    <form action="/admin/mutasibarang" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="hidden" name="inputan" value="tambahbarangmutasi">
            <input type="hidden" name="id" value="{{$mutasibarang->id}}">
            <input type="text" class="form-control" placeholder="Kode Barang" aria-describedby="button-addon2" name="kodebarang">
            <button class="btn btn-primary" type="submit"  onclick="return confirm('Menambahkan data di dalam form mutasi barang sama artinya dengan menghapus data barang di sistem, Anda Yakin??')" id="button-addon2">Tambah</button>
        </div>
        <a href="/admin/mutasibarang/import/{{$mutasibarang->id}}" class="btn btn-success">Import Data</a>
    </form>
    <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
    <div class="table-responsive">
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $item->kodebarang}}</td> 
        <td>{{ $item->namabarang}}</td> 
    </tr>
    @endforeach
        </tbody>
    </table>
        <a href="/admin/mutasibarang" class="btn btn-success my-3 float-end">Kembali</a>
    </div>
@endsection
