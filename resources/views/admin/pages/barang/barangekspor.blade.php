@extends('admin.layouts.template')

@section('main')
    <h1>Data Barang</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Banyak Barang</th>
                <th>Kondisi</th>
                <th>Sifat Barang</th>
                <th>Status Barang</th>
                <th>Tahun Pengadaan</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{$item->kodebarang}}</td>
        <td>{{$item->namabarang}}</td>
        <td>{{$item->jenis_barang->nama_jenisbarang}}</td>
        <td>{{$item->stock}} {{$item->satuanbarang->nama_satuan}}</td>
        <td>{{$item->kondisi}}</td>
        <td>{{$item->sifatbarang}}</td>
        <td>{{$item->status}}</td>
        <td>{{$item->tahunpengadaan}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
