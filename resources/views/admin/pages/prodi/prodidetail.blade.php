@extends('admin.layouts.template')

@section('main')
    <h3>Detail Program Studi</h3>
    <div class="table-responsive">
    <table class="table  ">
    <thead>
            <tr>
                <th>Info Program Studi</th>
                <th colspan="2" class="text-center"> <a href="/admin/prodi/{{$prodi->id }}/edit" class="link">Ubah Data</a></th>
            </tr>
    </thead>

    <tbody>
        <tr>
            <td>Nama Program Studi</td>
            <td>{{$prodi->nama_prodi}}</td>
        </tr>
        <tr>
            <td>Singkatan Nama</td>
            <td>{{$prodi->singkatan}}</td>

        </tr>
        <tr>
            <td>Jenjang Studi</td>
            <td>
              @if($prodi->jenjangstudi == "D4")
                Sarjana Terapan
              @elseif($prodi->jenjangstudi == "D3")
                Diploma
              @else
                -
              @endif
            </td>
        </tr>
        <tr>
            <td>Akreditasi</td>
            <td>{{$prodi->akreditasi}}</td>
        </tr>
        <tr>
            <td>Ketua Program Studi</td>
            <td>{{$prodi->ketuaprodi->nama}}</td>
        </tr>
        <tr>
            <td>Tahun Berdiri</td>
            <td>{{$prodi->tahunberdiri}}</td>
        </tr>

    </tbody>
    </table>
        <a href="/admin/prodi" class="btn btn-primary float-end mt-3">Kembali</a>
    </div>
@endsection
