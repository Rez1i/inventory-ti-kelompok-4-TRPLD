@extends('admin.layouts.template')

@section('main')
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
        </div>
        @endif
        <!-- <a href="/admin/dosen/export" class="btn btn-success my-3">Ekspor Data</a> -->
        <div class="table-responsive">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Notifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada notifikasi</td>
                        </tr>
                    @else
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->notifikasi }}</td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <a href="/admin" class="btn btn-primary float-end">Kembali</a>
        </div>
@endsection
