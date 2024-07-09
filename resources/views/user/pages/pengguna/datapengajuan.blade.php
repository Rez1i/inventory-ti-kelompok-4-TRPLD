@extends('admin.layouts.template')

@section('main')
    <h2>Pengajuan Peminjaman</h2>
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
        </div>
        @endif
        <div class="table-responsive">
            <table id="example2" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>ID Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->pengajuanbarang->namabarang}}</td> 
                        <td>{{ $item->status}}</td>
                        @if( $item->status == 'Sudah Diproses')
                        <td>-</td>
                        @elseif($item->status == 'Ditolak')
                        <td>-</td>
                        @else
                        <td class="text-center">
                            <b>
                                <a href="/pengajuanbatal/{{$item->id}}" class="link">Batalkan Pengajuan</a>
                            </b>
                        </td>
                        @endif        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
