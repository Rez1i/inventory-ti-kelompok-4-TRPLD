<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\barang;
use App\Models\transaksi;
use App\Models\notifikasi;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\pengajuanpeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransaksiController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        $data = transaksi::all();
        return view('admin/pages/transaksi/transaksi', ['data' => $data]);
    }
    public function edit(transaksi $transaksi)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        return view('admin/pages/transaksi/transaksidetail', ['transaksi' => $transaksi]);
    }

    public function datapengajuanpeminjaman()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = pengajuanpeminjaman::all();
        return view('/admin/pages/pengajuan/pengajuanpeminjaman', ['data' => $data]);
    }

    public function peminjamandengandata($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = pengajuanpeminjaman::find($id);
        return view('/admin/pages/transaksi/peminjaman', ['data' => $data]);
    }

    public function tolakpengajuan($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = pengajuanpeminjaman::find($id);
        if (!$data) {
            return back()->with('Failed', 'Ada Kesalahan Pada Sistem');
        }
        $ubahdata = $data->update(['status' => 'Ditolak']);
        if (!$ubahdata) {
            return back()->with('Failed', 'Penolakan pengajuan gagal.');
        }
        notifikasi::create([
            'judul' => 'Pemberitahuan',
            'user_id' => $data->user_id,
            'notifikasi' => 'Mohon maaf, pengajuan peminjaman barang dengan id = ' . $id . 'Ditolak'
        ]);
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menolak Pengajuan peminjaman dengan id = ' . $id
        ]);
        return back()->with('success', 'Data pengajuan berhasil ditolak');
    }

    public function terimapengajuan($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = pengajuanpeminjaman::find($id);
        if (!$data) {
            return back()->with('Failed', 'Ada Kesalahan Pada Sistem');
        }
        $ubahdata = $data->update(['status' => 'Diterima']);
        if (!$ubahdata) {
            return back()->with('Failed', 'Penerimaan pengajuan gagal.');
        }
        notifikasi::create([
            'judul' => 'Pemberitahuan',
            'user_id' => $data->user_id,
            'notifikasi' => 'Selamat, pengajuan peminjaman barang dengan id = ' . $id . 'Diterima. Segera melakukan transaksi dengan pihak terkait.'
        ]);
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menerima Pengajuan peminjaman dengan id = ' . $id
        ]);
        return back()->with('success', 'Data pengajuan berhasil diterima');
    }


    public function peminjaman()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return view('admin/pages/transaksi/transaksipeminjaman');
    }

    public function pengembalian()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return view('admin/pages/transaksi/transaksipengembalian');
    }

    public function store(request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        if ($request->jenistransaksi == "peminjaman") {
            $validatedData = $request->validate([
                'kodebarang' => 'required|max:255',
                'peminjam' => 'required|email|max:255',
                'bataswaktu' => 'required'
            ]);

            if (strtotime($validatedData['bataswaktu']) < strtotime('today')) {
                // 'bataswaktu' adalah tanggal sebelum hari ini, maka tampilkan error
                return back()->with('Failed', 'Batas Waktu yang Dinputkan tidak valid');
            }

            $barang = barang::where('kodebarang', $validatedData['kodebarang'])->where('sifatbarang', 'Boleh Dipinjam')->where('kondisi', 'Baik')->first();
            if (!$barang) {
                return back()->with('Failed', 'Data barang tidak ditemukan di sistem atau barang tidak boleh dipinjam');
            }
            $peminjam = User::where('email', $validatedData['peminjam'])->first();

            if (!$peminjam) {
                return back()->with('Failed', 'Email tidak terdaftar di sistem');
            }
            pengajuanpeminjaman::where('barang_id', $barang->id)->where('user_id', $peminjam->id)->where('status', 'Diterima')->update(['status' => 'Sudah Diproses']);

            $validatedData['barang_id'] = $barang->id;
            $validatedData['user_id'] = Auth::id();
            $validatedData['waktupinjam'] = Carbon::now()->tz('Asia/Jakarta');

            $validatedData['status'] = "Sedang Dipinjam";
            $validatedData['sarankomentar'] = "-";

            $tambahtransaksi = transaksi::create($validatedData);
            if (!$tambahtransaksi) {
                return back()->with('Failed', 'Peminjaman Gagal');
            }
            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambahkan data peminjaman dengan id = ' . $tambahtransaksi->id
            ]);
            $barang->update(['status' => 'Sedang dipinjam']);
            return redirect('/admin/transaksi')->with('success', 'Peminjaman Berhasil');
        } else {
            $validatedData = $request->validate([
                'kodebarang' => 'required|max:255',
                'peminjam' => 'required|email|max:255'
            ]);
            $validatedData['waktudikembalikan'] = Carbon::now()->tz('Asia/Jakarta');
            $barang = barang::where('kodebarang', $validatedData['kodebarang'])->first();

            $datatransaksi = transaksi::where('barang_id', $barang->id)->where('peminjam', $validatedData['peminjam'])->where('status', 'Sedang Dipinjam')->first();
            if (!$datatransaksi) {
                return back()->with('Failed', 'Data peminjaman tidak ditemukan');
            }

            if ($validatedData['waktudikembalikan']->greaterThan($datatransaksi->bataswaktu)) {
                $validatedData['status'] = "Selesai Terlambat";
            } else {
                $validatedData['status'] = "Selesai";
            }

            $datatransaksi->update($validatedData);
            if (!$datatransaksi) {
                return back()->with('Failed', 'Pengembalian gagal');
            }
            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambahkan data pengembalian dengan id = ' . $datatransaksi->id
            ]);
            $barang->update(['status' => 'Tersedia']);
            return redirect('/admin/transaksi')->with('success', 'Pengembalian berhasil');
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = transaksi::findOrFail($id);
        $hapusdata = $data->delete();
        if (!$hapusdata) {
            return redirect('/admin/transaksi')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus data transaksi dengan id = ' . $id
        ]);
        $barang = barang::find($data->barang_id);
        $barang->update(['status' => 'Tersedia']);
        return redirect('admin/transaksi')->with('success', 'Data has Been Deleted');
    }

    public function exporttransaksi()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = transaksi::all();
        return view('admin.pages.transaksi.transaksiekspor', ['data' => $data]);
    }

    public function sedangdipinjam()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = transaksi::where('status', 'Sedang Dipinjam')->get();
        return view('admin.pages.transaksi.sedangdipinjam', ['data' => $data]);
    }
}