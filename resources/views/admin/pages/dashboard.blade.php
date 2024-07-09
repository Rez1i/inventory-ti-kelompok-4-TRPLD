@extends('admin.layouts.template')

@section('main')
    <div class="container-fluid">
        <!-- Page Heading -->
        @can('isAdministrator')
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h4>Selamat Datang, {{ auth()->user()->username }}</h4>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('Failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('Failed') }}
                </div>
            @endif
            <div class="row">
                <div class="card col p-3 m-1 bg-light">
                    <div class="card-header bg-info text-white">
                        <h3>Log Aktivitas User</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($log as $item)
                            <p>{{ $item->created_at }} // {{ $item->useraktivitas->username }} // {{ $item->aktivitas }}</p>
                        @endforeach
                    </div>
                    <div class="card-footer d-flex justify-content-end bg-light">
                        {{ $log->links() }}
                    </div>
                </div>

                <div class="card col-3 p-3 m-1 bg-light">
                    <div class="card-header bg-info text-white">
                        <h3>Backup Sistem</h3>
                    </div>
                    <div class="card-body">
                        <p>Backup sistem adalah proses membuat salinan data yang lengkap untuk melindungi informasi penting dari
                            kehilangan atau kerusakan. Saat Anda melakukan backup, data yang sebelumnya disimpan akan digantikan
                            oleh salinan baru, memastikan bahwa hanya versi terbaru yang tersedia untuk pemulihan.</p>
                    </div>
                    <div class="card-footer ">
                        <a href="/backup" class="btn btn-primary float-end text-white"> Backup Data</a>
                    </div>
                </div>

                <div class="card col-3 p-3 m-1 bg-light">
                    <div class="card-header bg-info text-white">
                        <h3>Restore</h3>
                    </div>
                    <div class="card-body">
                        <p>Restore adalah proses untuk mengembalikan data dari salinan cadangan yang telah dibuat sebelumnya.
                            Dengan fitur ini, Anda dapat memulihkan informasi penting yang mungkin hilang atau terganggu.
                            Restore data sekarang.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/restore" class="btn btn-primary float-end text-white">Restore Data</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card p-5 col-7 m-1">
                    <div class="">
                        <a href="/admin/user/create" class="btn btn-primary float-end ">Tambah User</a>
                        <h2>User</h2>
                    </div>
                    <table id="example2" class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        <form action="/admin/user/{{ $item->id }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Semua data yang berhubungan dengan user ini akan dihapus, anda yakin??')">Remove</button>
                                        </form>
                                        <a href="/admin/userdetail/{{ $item->id }}" class="btn btn-warning">Detail</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card p-5 col m-1">
                    <div class="card-header bg-info text-white">
                        Laporan Dan Masukan
                    </div>
                    <div class="card-body">
                        @if ($masalah->count() != 0)
                            @foreach ($masalah as $item)
                                <p>{{ $item->created_at }} // {{ $item->user_id }} // {{ $item->laporandanmasukan }} // <a
                                        href="/laporkanmasalah/{{ $item->id }}/edit">Balas</a></p>
                            @endforeach
                        @else
                            <p>Tidak ada saran dan masukan</p>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-end bg-light">
                        {{ $masalah->links() }}
                    </div>
                </div>






                <!-- Modal -->
            @endcan
            @can('isAdmin')
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1>Dashboard</h1>
                </div>

                <div class="row">
                    {{-- <div class="col-lg-3 text-center">
                        <div class="row">
                            <div class="col-lg-12" style="background-color: #ffd525">
                                <h6>User</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4" style="background-color: #ffae00">
                                <h6>Mahasiswa</h6>
                            </div>
                            <div class="col-lg-4" style="background-color: #7cff25">
                                <h6>Dosen</h6>
                            </div>
                            <div class="col-lg-4" style="background-color: #ff2525">
                                <h6>Staff</h6>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-dismissible fade show" role="alert"
                                    style="background-color: #ffae00;color: #fff;border: 1px solid #ffae00; font-size:18px;">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <i class="fa-solid fa-circle-exclamation"></i> Selamat Datang
                                    <b>{{ Auth::user()->username }}</b>!
                                    <br>
                                    <div style="text-indent: 22px">
                                        Di <b>SIIBALA-TI</b> - Sistem Informasi Inventaris Barang Labor Di Jurusan TI
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 p-5">
                                <div class="card shadow text-center bg-success" style="width: 7rem; height: 7rem;">
                                    <a href="/admin/barang"
                                        class="d-flex align-items-center justify-content-center h-100 nav-link">
                                        <b>Barang</b>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4 p-5">
                                <div class="card shadow text-center bg-primary" style="width: 7rem; height: 7rem;">
                                    <a href="/admin/transaksi"
                                        class="d-flex align-items-center justify-content-center h-100 nav-link">
                                        <b>Manajemen Peminjaman</b>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 p-5">
                                <div class="card shadow text-center bg-warning" style="width: 7rem; height: 7rem;">
                                    <a href="/admin/user"
                                        class="d-flex align-items-center justify-content-center h-100 nav-link">
                                        <b class="text-white">User</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card p-5">
                            <h2>Pengajuan Peminjaman</h2>
                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @elseif(session()->has('Failed'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('Failed') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered">
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
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->userpeminjam->email }}</td>
                                                <td>{{ $item->pengajuanbarang->namabarang }}</td>
                                                @if ($item->status == 'Diterima')
                                                    <td>{{ $item->status }}</td>
                                                    <td><b><a href="/transaksipeminjaman/{{ $item->id }}"
                                                                class="link">Lanjutkan Transaksi</a></b></td>
                                                @elseif($item->status == 'Sudah Diproses')
                                                    <td>{{ $item->status }}</td>
                                                    <td>-</td>
                                                @else
                                                    <td class="text-center">
                                                        <b>
                                                            <a href="/tolakpengajuan/{{ $item->id }}" class="link"><i
                                                                    class="bi bi-ban"></i> Tolak</a>
                                                            |
                                                            <a href="/terimapengajuan/{{ $item->id }}" class="link"><i
                                                                    class="bi bi-check-square-fill"></i>
                                                                Terima</a>
                                                        </b>
                                                    </td>
                                                    <td>-</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            @endcan

            @can('isPimpinan')
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1>Dashboard</h1>
                    {{-- <h1>Selamat Datang, {{ auth()->user()->username }}</h1> --}}
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar lg"
                                        style="background: #ffae00; border: 3px solid #ffae00; width: 80px; height: 80px; border-radius: 50%; overflow: hidden;">
                                        @if (Auth::user()->profile_photo != '-')
                                            <img src="/storage/{{ Auth::user()->profile_photo }}" alt="User Avatar"
                                                style="width: 100%; height: auto;">
                                        @else
                                            <img src="/storage/defaultfoto.png" alt="Default Avatar"
                                                style="width: 100%; height: auto;">
                                        @endif
                                    </div>
                                    <div class="user-info ms-3">
                                        <h2 class="h5 mb-1"> {{ Auth::user()->username }} </h2>
                                        <span class="text-muted"> {{ Auth::user()->email }} </span>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Email</span> <span>{{ Auth::user()->email }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Username</span> <span>{{ Auth::user()->username }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Role / Level</span>
                                        <span class="badge rounded-pill bg-warning text-white">{{ Auth::user()->role }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Status</span>
                                        <span class='text-success' data-bs-toggle='tooltip' title='Aktif'>
                                            <i class="fa-solid fa-circle-check"></i> Aktif
                                        </span>
                                    </li>
                                </ul>
                                <div class="mt-3 text-center">
                                    <a href="/editprofile" class="btn btn-outline-secondary rounded-pill"
                                        data-bs-toggle="tooltip" title="Ubah Pengaturan">
                                        <i class="fa-solid fa-gear"></i>
                                        <span> Pengaturan Akun & Profil </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="alert alert-dismissible fade show" role="alert"
                                style="background-color: #ffae00;color: #fff;border: 1px solid #ffae00; font-size:18px;">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <i class="fa-solid fa-circle-exclamation"></i> Selamat Datang
                                <b>{{ Auth::user()->username }}</b>!
                                <br>
                                <div style="text-indent: 22px">
                                    Di <b>SIIBALA-TI</b> - Sistem Informasi Inventaris Barang Labor Di Jurusan TI
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div style="background-color: #ffae00;color: #fff;">
                                <div class="row p-3">
                                    <div class="col-md-12 text-center">
                                        <h1>{{ $totalbarang }}</h1>
                                        <h2>Data Barang</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-5">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="chart-area">
                                                {!! $kondisibarangchart->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="chart-area">
                                                {!! $barangchart->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="chart-area">
                                                {!! $barangMasukKeluarChart->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            {!! $kategoriBarangChart->container() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div style="background-color: #ffae00;color: #fff;">
                                <div class="row p-3">
                                    <div class="col-md-12 text-center">
                                        <h2>Aktivitas Barang</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h2>Jumlah Peminjaman</h2>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="timeRange" class="form-control ">
                                                        <option value="week">Minggu Ini</option>
                                                        <option value="month">Per Bulan</option>
                                                        <option value="year">Per Tahun</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="chart-area-year" class="chart-area" style="display: none;">
                                                {!! $peminjamanYearChart->container() !!}
                                            </div>
                                            <div id="chart-area-month" class="chart-area" style="display: none;">
                                                {!! $peminjamanMonthChart->container() !!}
                                            </div>
                                            <div id="chart-area-week" class="chart-area" style="display: none;">
                                                {!! $peminjamanWeekChart->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-6">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            {!! $mutasiBarangChart->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            {!! $barangBelumDikembalikanChart->container() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="{{ $kondisibarangchart->cdn() }}"></script>
                {{ $kondisibarangchart->script() }}

                <script src="{{ $barangchart->cdn() }}"></script>
                {{ $barangchart->script() }}

                <script src="{{ $peminjamanYearChart->cdn() }}"></script>
                {{ $peminjamanYearChart->script() }}

                <script src="{{ $peminjamanMonthChart->cdn() }}"></script>
                {{ $peminjamanMonthChart->script() }}

                <script src="{{ $peminjamanWeekChart->cdn() }}"></script>
                {{ $peminjamanWeekChart->script() }}

                <script src="{{ $kategoriBarangChart->cdn() }}"></script>
                {{ $kategoriBarangChart->script() }}

                <script src="{{ $barangMasukKeluarChart->cdn() }}"></script>
                {{ $barangMasukKeluarChart->script() }}

                <script src="{{ $mutasiBarangChart->cdn() }}"></script>
                {{ $mutasiBarangChart->script() }}

                <script src="{{ $barangBelumDikembalikanChart->cdn() }}"></script>
                {{ $barangBelumDikembalikanChart->script() }}

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const timeRangeSelect = document.getElementById('timeRange');
                        const chartAreas = {
                            year: document.getElementById('chart-area-year'),
                            month: document.getElementById('chart-area-month'),
                            week: document.getElementById('chart-area-week')
                        };

                        function showChart(selected) {
                            Object.keys(chartAreas).forEach(key => {
                                chartAreas[key].style.display = key === selected ? 'block' : 'none';
                            });
                        }

                        // Default to month view
                        showChart('week');

                        timeRangeSelect.addEventListener('change', function() {
                            showChart(this.value);
                        });
                    });
                </script>
            @endcan

            @can('isUser')
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4>Selamat Datang, {{ auth()->user()->username }}</h4>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Pengajuan Peminjaman
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuan }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-arrow-up-right-circle-fill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Barang Yang Dipinjam
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sedangdipinjam }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-arrow-down-left-circle-fill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Riwayat Peminjaman
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $riwayatpeminjaman }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-card-text fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Pemberitahuan Sistem
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pemberitahuan }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-bell-fill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($beritaterbaru->isNotEmpty())
                    <h3 class="mb-3"><b>Berita Terbaru</b></h3>
                    <div class="row">
                        @foreach ($beritaterbaru->take(3) as $item)
                            <div class="col-lg-4 m-0 p-2">
                                <div class="card border-3 shadow" style="width: 100%; height: 26rem;">
                                    <img src="/storage/{{ $item->gambar }}" class="card-img-top" alt="..."
                                        style="width:100%;height:170px;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->judul }}</h5>
                                        <p class="card-text">{{ $item->isi_berita }} <a
                                                href="/admin/beritadetail/{{ $item->id }}"
                                                class="link">Selengkapnya</a></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($beritalainnya->isNotEmpty())
                    <h3 class="my-3"><b>Berita Lainnya</b></h3>
                    <section>
                        @foreach ($beritalainnya as $item)
                            <div class="card mb-3 border-3 shadow" style="width: 100%; height:100%;">
                                <div class="row g-0">
                                    <div class="col-md-4 align-items-center">
                                        <img src="/storage/{{ $item->gambar }}" class="card-img img-fluid rounded-start"
                                            style="height: 100%; object-fit: cover;" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text">{!! Str::limit($item->isi_berita, 200, '...') !!} <a
                                                    href="/admin/beritadetail/{{ $item->id }}"
                                                    class="link">Selengkapnya</a></p>
                                            <p class="card-text"><small
                                                    class="text-body-secondary">{{ $item->updated_at }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </section>

                    <div class="d-flex justify-content-end mt-4">
                        @if ($beritalainnya->previousPageUrl())
                            <a href="{{ $beritalainnya->previousPageUrl() }}" class="btn btn-primary mx-1">&laquo;
                                Previous</a>
                        @else
                            <span class="btn btn-secondary disabled mx-1">&laquo; Previous</span>
                        @endif

                        @if ($beritalainnya->nextPageUrl())
                            <a href="{{ $beritalainnya->nextPageUrl() }}" class="btn btn-primary mx-1">Next &raquo;</a>
                        @else
                            <span class="btn btn-secondary disabled mx-1">Next &raquo;</span>
                        @endif
                    </div>
                @endif
            @endcan
        </div>

    @endsection
