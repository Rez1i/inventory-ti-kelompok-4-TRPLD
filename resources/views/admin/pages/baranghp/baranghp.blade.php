@extends('admin.layouts.template')

@section('main')
    @include('admin.pages.barang.cardnavigasibarang')
    <h2>Data Barang Habis Pakai</h2>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
    <div class="table-responsive">
        <table id="example2" class="table table-bordered ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->kodebarang }}</td>
                        <td class="text-center"><img src="/storage/{{ $item->barcode }}" alt="foto barang"><br>
                            {{ $item->kodebarang }}
                        </td>
                        <td>{{ $item->namabarang }}</td>
                        <td>{{ $item->kategori_baranghp->nama_kategoribarang }}</td>
                        <td>
                            @can('isAdmin')
                                {{-- <form action="/admin/baranghp/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Yakin bos')">Remove</button>
                                </form> --}}
                                <a href="/admin/baranghp/{{ $item->id }}/edit" class="btn btn-success">Edit</a>
                            @endcan
                            <a href="/admin/baranghpdetail/{{ $item->id }}" class="btn btn-warning">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('print_barcodehp') }}" target="_blank">Print</a>
    </div>
@endsection
