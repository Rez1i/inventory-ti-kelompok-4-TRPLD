@extends('admin.layouts.template')

@section('main')
    <h1>Data Barang Keluar</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Penerima</th>
                <th>Nama Barang</th>
                <th>Penanggung Jawab</th>
                <th>Banyak Barang</th>
                <th>Satuan</th>
                <th>Tujuan</th>
                <th>Waktu Transaksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{$item->penerima}}</td>
        <td>{{$item->barang_keluar->namabarang}}</td>
        <td>{{$item->penanggung_jawab->email}}</td>
        <td>{{$item->banyakbarang}}</td>
        <td>{{$item->satuanbarangkeluar->nama_satuan }}</td>
        <td>{{$item->tujuan}}</td>
        <td>{{$item->updated_at}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
