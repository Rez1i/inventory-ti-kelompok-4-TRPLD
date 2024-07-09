@extends('admin.layouts.template')

@section('main')
    {{-- Pimpinan --}}
    <h2>Data Barang Inventaris</h2>
    <div class="table-responsive">
        <table id="example1" class="table table-bordered ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->kodebarang }}</td>
                        <td><img src="/storage/{{ $item->barcode }}" alt="foto barang">
                        </td>
                        <td>{{ $item->namabarang }}</td>
                        <td>{{ $item->jenis_barang->nama_jenisbarang }}</td>
                        <td>
                            @can('isAdmin')
                                <!-- <form action="/admin/barang/{{ $item->id }}" method="post" class="d-inline">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @method('delete')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @csrf
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini')">Remove</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </form> -->
                                <a href="/admin/barang/{{ $item->id }}/edit" class="btn btn-success">Edit</a>
                            @endcan
                            <a href="/admin/barangdetail/{{ $item->id }}" class="btn btn-warning">Detail</a>
                        </td>
                    </tr>
                @endforeach
                @foreach ($datahp as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->kodebarang }}</td>
                    <td><img src="/storage/{{ $item->barcode }}" alt="foto barang">
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


    </div>
@endsection
