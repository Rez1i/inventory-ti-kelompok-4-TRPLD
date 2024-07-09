@extends('admin.layouts.template')

@section('main')
@include('admin.pages.transaksi.cardnavigasitransaksi')
    <h2>Pengajuan Peminjaman</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
        @endif
        <div class="table-responsive">
            <table id="example2" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->userpeminjam->email}}</td> 
                        <td>{{ $item->pengajuanbarang->namabarang}}</td>
                        @if($item->status == 'Diterima')
                            <td>{{ $item->status}}</td>
                            <td><b><a href="/transaksipeminjaman/{{$item->id}}" class="link">Lanjutkan Transaksi</a></b></td>
                        @elseif($item->status == 'Sudah Diproses')
                        <td>{{ $item->status}}</td>
                        <td>-</td>
                        @elseif($item->status == 'Sedang Diajukan') 
                        <td class="text-center">
                            <b>
                               
                                <a href="/tolakpengajuan/{{$item->id}}" class="link"><i class="bi bi-ban">Tolak</i></a>
                                |
                                <a href="/terimapengajuan/{{$item->id}}" class="link"><i class="bi bi-check-square-fill">Terima</i></a>
                            </b>
                        </td>
                        <td>-</td>
                        @else 
                        <td>-</td>
                        <td>-</td> 
                        @endif      
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
