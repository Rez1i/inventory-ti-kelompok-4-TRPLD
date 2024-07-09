@extends('admin.layouts.template')

@section('main')
    <h1>Data Barang Habis pakai</h1>
    <p>Ekspor File :</p>
    <table id="example1" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Tahun Pengadaan</th>
                <th>Banyak Barang</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{$item->kodebarang}}</td>
        <td>{{$item->namabarang}}</td>
        <td>{{$item->kategori_baranghp->nama_kategoribarang}}</td>
        <td>{{$item->tahunpengadaan}}</td>
        <td>{{$item->stock}} {{$item->satuanbaranghp->nama_satuan}}</td>
      
    </tr>
    @endforeach
        </tbody>
    </table>
@endsection
