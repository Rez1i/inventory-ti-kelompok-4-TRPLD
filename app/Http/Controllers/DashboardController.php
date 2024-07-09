<?php

namespace App\Http\Controllers;

use App\Charts\BarangBelumDikembalikanChart;
use Exception;
use App\Models\User;
use App\Models\barang;
use App\Models\berita;
use App\Models\masalah;
use App\Models\transaksi;
use App\Models\notifikasi;
use App\Charts\BarangChart;
use Illuminate\Support\Str;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Charts\PeminjamanChart;
use App\Charts\MutasiBarangChart;
use App\Charts\KondisiBarangChart;
use App\Charts\KategoriBarangChart;
use App\Charts\PeminjamanWeekChart;
use App\Charts\PeminjamanYearChart;
use App\Models\pengajuanpeminjaman;
use App\Charts\PeminjamanMonthChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Charts\BarangMasukKeluarChart;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == "Admin") {
                return redirect('/admin');
            } elseif (Auth::user()->role == "Pimpinan") {
                return redirect('/adminpimpinan');
            } elseif (Auth::user()->role == "User") {
                return redirect('/adminuser');
            } elseif (Auth::user()->role == "Administrator") {
                return redirect('/administrator');
            }
        } else {
            $beritaterbaru = Berita::orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    // Menghapus tag HTML, mengganti &nbsp; dengan spasi biasa, dan membatasi 100 karakter
                    $item->isi_berita = Str::limit(str_replace('&nbsp;', ' ', strip_tags($item->isi_berita)), 100);
                    return $item;
                });
            return view('user.pages.dashboard', ['beritaterbaru' => $beritaterbaru]);
        }
    }

    public function dashboarduser()
    {
        if (!Gate::allows('isUser')) {
            return redirect('/');
        }
        $pengajuan = pengajuanpeminjaman::where('user_id', Auth::id())->count();
        $sedangdipinjam = transaksi::where('peminjam', Auth::user()->email)->where('status', 'Sedang Dipinjam')->count();
        $riwayatpeminjaman = transaksi::where('peminjam', Auth::user()->email)->where('status', 'Selesai')->orwhere('status', 'Selesai Terlambat')->count();
        $pemberitahuan = notifikasi::where('user_id', Auth::id())->count();
        $data = pengajuanpeminjaman::where('status', 'Sedang Diajukan');
        $beritaterbaru = Berita::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Menghapus tag HTML, mengganti &nbsp; dengan spasi biasa, dan membatasi 100 karakter
                $item->isi_berita = Str::limit(str_replace('&nbsp;', ' ', strip_tags($item->isi_berita)), 100);
                return $item;
            });

        $beritalainnya = berita::whereNotIn('id', $beritaterbaru->pluck('id'))->orderBy('created_at', 'desc')->simplePaginate(5);
        return view('/user/pages/dashboard', [
            'pengajuan' => $pengajuan,
            'sedangdipinjam' => $sedangdipinjam,
            'riwayatpeminjaman' => $riwayatpeminjaman,
            'pemberitahuan' => $pemberitahuan,
            'beritaterbaru' => $beritaterbaru,
            'beritalainnya' => $beritalainnya,
            'data' => $data
        ]);
    }

    public function dashboardadmin()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = pengajuanpeminjaman::where('status', 'Sedang Diajukan')->get();
        return view('/admin/pages/dashboard', ['data' => $data]);
    }

    public function dashboardadministrator()
    {
        if (!Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        $data = User::wherenot('email', Auth::user()->email)->get();
        $logaktivitas = logaktivitas::orderByDesc('created_at')->simplepaginate(10);
        $masalah = masalah::orderByDesc('created_at')->where('tanggapan', '-')->simplepaginate(10);
        return view('/admin/pages/dashboard', ['data' => $data, 'log' => $logaktivitas, 'masalah' => $masalah]);
    }

    public function dashboardpimpinan(
        KondisiBarangChart $kondisibarangchart,
        BarangChart $barangchart,
        PeminjamanYearChart $peminjamanYearChart,
        PeminjamanMonthChart $peminjamanMonthChart,
        PeminjamanWeekChart $peminjamanWeekChart,
        KategoriBarangChart $kategoriBarangChart,
        BarangMasukKeluarChart $barangMasukKeluarChart,
        MutasiBarangChart $mutasiBarangChart,
        BarangBelumDikembalikanChart $barangBelumDikembalikanChart
    ) {
        $peminjamanMonthChart = $peminjamanMonthChart->build();
        $peminjamanYearChart = $peminjamanYearChart->build();
        $peminjamanWeekChart = $peminjamanWeekChart->build();
        $kategoriBarangChart = $kategoriBarangChart->build();
        $barangMasukKeluarChart = $barangMasukKeluarChart->build();
        $mutasiBarangChart = $mutasiBarangChart->build();
        $barangBelumDikembalikanChart = $barangBelumDikembalikanChart->build();
        $chartData1 = $kondisibarangchart->build();
        $chartData2 = $barangchart->build();
        $totalbarang = barang::count();

        // Pass the chart data to the view
        return view('admin.pages.dashboard', [
            'kondisibarangchart' => $chartData1,
            'barangchart' => $chartData2,
            'peminjamanMonthChart' => $peminjamanMonthChart,
            'peminjamanYearChart' => $peminjamanYearChart,
            'peminjamanWeekChart' => $peminjamanWeekChart,
            'kategoriBarangChart' => $kategoriBarangChart,
            'barangMasukKeluarChart' => $barangMasukKeluarChart,
            'mutasiBarangChart' => $mutasiBarangChart,
            'barangBelumDikembalikanChart' => $barangBelumDikembalikanChart,
            'totalbarang' => $totalbarang
        ]);
    }
}
