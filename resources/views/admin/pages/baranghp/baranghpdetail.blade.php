@extends('admin.layouts.template')

@section('main')
@can('isAdmin')
    <h2>Detail Barang Habis Pakai</h2>

    <div class="table-responsive">
    <table class="table table">
    <thead>
            <tr>
                <th colspan="3">Info Barang</th>
            </tr>
    </thead>

    <tbody>
        <tr>
            <td>Kode Barang</td>
            <td>{{$baranghp->kodebarang}}</td>
            @if($baranghp->foto == "-")
            <td style="width: 280px;" rowspan="6"><img src="/storage/defaultfoto.png" alt="default" style="width:280px;height:270px;"></td>
            @else
            <td style="width: 280px;" rowspan="6"><img src="/storage/{{$baranghp->foto}}" alt="foto baranghp" style="width:280px;height:270px;"></td>
            @endif

        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{$baranghp->namabarang}}</td>

        </tr>
        <tr>
            <td>Kategori Barang</td>
            <td>{{$baranghp->kategori_baranghp->nama_kategoribarang}}</td>
        </tr>
        <tr>
            <td>Tahun Pengadaan</td>
            <td>{{$baranghp->tahunpengadaan}}</td>
        </tr>
        <tr>
            <td>Stock</td>
            <td>{{$baranghp->stock}}</td>

        </tr>
        <tr>
            <td>Satuan</td>
            <td>{{$baranghp->satuanbaranghp->nama_satuan}}</td>


        </tr>
    </tbody>

    </table>
    <h2 class="my-3">Riwayat Transaksi</h2>
    <div class="table-responsive my-3">
    <table  id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
        @foreach($riwayattransaksi as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $item->created_at}}</td>
            <td>{{ $item->banyakbarang}}</td>
        </tr>
        @endforeach
            </tbody>
        </table>
        </div>
        <a href="/admin/baranghp" class="btn btn-primary float-end">Kembali</a>
    </div>
    @endcan
    @can('isUser')
    <h2>Detail Barang</h2>
    <div class="table-responsive">
    <table class="table">
    <thead>
            <tr>
                <th colspan="3">Info Barang</th>
            </tr>
    </thead>

    <tbody>
        <tr>
            <td>Kode Barang</td>
            <td>{{$baranghp->kodebarang}}</td>
            @if($baranghp->foto == "-")
            <td style="width: 270px;" rowspan="5"><img src="/storage/defaultfoto.png" alt="default" style="width:250px;height:250px;"></td>
            @else
            <td style="width: 270px;" rowspan="5"><img src="/storage/{{$baranghp->foto}}" alt="foto baranghp" style="width:250px;height:250px;"></td>
            @endif
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{$baranghp->namabarang}}</td>

        </tr>
        <tr>
            <td>Kategori Barang</td>
            <td>{{$baranghp->kategori_baranghp->nama_kategoribarang}}</td>
        </tr>
        <tr>
            <td>Tahun Pengadaan</td>
            <td>{{$baranghp->tahunpengadaan}}</td>
        </tr>
        <tr>
            <td colspan="2"><a href="/barang" class="btn btn-primary">Kembali</a></td>
        </tr>
    </tbody>
    </table>


    </div>

    @endcan
@endsection
