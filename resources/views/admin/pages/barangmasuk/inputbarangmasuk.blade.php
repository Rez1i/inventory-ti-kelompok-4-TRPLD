@extends('admin.layouts.template')

@section('main')
    <h1>Barang Masuk</h1>
    <h5>Pemasok: {{$barangmasuk->pemasok}}</h5>
    <h5>Total Barang: {{$barangmasuk->stock}}</h5>
    <h5>Tahun Pengadaan: {{$barangmasuk->tahunpengadaan}}</h5>
    <h5>Status: {{$barangmasuk->status}}</h5>
    <hr>

    {{-- Tombol tambah barang hanya ditampilkan jika pengguna memiliki izin 'isAdmin' --}}
    @can('isAdmin')
    <div class="">
        <p>Tambah Barang :</p>
        <a href="/admin/tambahbarangmasuk/{{$barangmasuk->id}}" class="btn btn-primary mt-1 mb-3 col-2 d-inline-block" style="width:auto" >Barang Tetap</a>
        <a href="/admin/tambahbaranghpmasuk/{{$barangmasuk->id}}" class="btn btn-primary mt-1 mb-3 col-2 d-inline-block" style="width:auto" >Barang habis pakai</a>
        <a href="/admin/tambahbarangimport/{{$barangmasuk->id}}" class="btn btn-success mt-1 mb-3 col-2 d-inline-block" style="width:auto">Import Data</a>
    </div>
    @endcan

    {{-- Pesan success atau failed --}}
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    {{-- Tabel daftar barang --}}
    <div class="table-responsive">
        <table id="example2" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Banyak Barang</th>
                    @can('isAdmin')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($detail as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kodebarang }}</td>
                        <td>{{ $item->namabarang }}</td> 
                        <td>{{ $item->banyakbarang }} {{ $item->satuandbmasuk->nama_satuan }}</td>  
                        @can('isAdmin')
                        <td>
                            <form action="/admin/baranghapus/{{ $item->kodebarang }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="barangmasuk_id" value="{{ $barangmasuk->id }}">
                                <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Remove</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tombol kembali --}}
        <a href="/admin/barangmasuk" class="btn btn-primary mt-1 mb-3 col-2 d-inline-block float-end" style="width:auto" >Kembali</a>
    </div>
@endsection
