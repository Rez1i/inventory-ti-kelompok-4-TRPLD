@extends('admin.layouts.template')

@section('main')
    <h1>Detail Barang keluar</h1>
   
    <div class="table-responsive">
    <table class="table">
    <thead>
            <tr>
                <th>Information</th>
                <th class="text-center"><a href="/admin/barangkeluar/{{$data->id }}/edit" class="link">Ubah Data</a></th>
                
            </tr>
    </thead>
   
    <tbody>
        <tr>
            <td>Penerima</td>
            <td>{{$data->penerima}}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{$data->barang_keluar->namabarang}}</td>
           
        </tr>
        <tr>
            <td>Penanggung Jawab</td>
            <td>{{$data->penanggung_jawab->email}}</td>
        </tr>
        <tr>
            <td>Jumlah Barang</td>
            <td>{{$data->banyakbarang}}</td>
        </tr>
        <tr>
            <td>Satuan</td>
            <td>{{$data->satuanbarangkeluar->nama_satuan }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>{{$data->tujuan}}</td>
        </tr>
        <tr>
            <td>Waktu Transaksi</td>
            <td>{{$data->updated_at}}</td>
        </tr>
    </tbody>
    </table>
       
        <a href="/admin/barangkeluar" class="btn btn-primary float-end mt-3">Kembali</a>
    </div>
@endsection
