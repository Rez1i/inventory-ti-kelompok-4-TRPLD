<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\satuan;
use App\Models\baranghp;
use App\Models\transaksi;
use App\Models\penempatan;
use App\Models\jenisbarang;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\pengajuanpeminjaman;
use App\Models\pemindahaninventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Milon\Barcode\Facades\DNS1DFacade;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    public function index()
    {
        $data = barang::all();
        $datahp = baranghp::all();
        if (Gate::allows('isAdmin')) {
            return view('admin/pages/barang/barang', ['data' => $data]);
        } elseif (Gate::allows('isPimpinan')) {
            return view('pimpinan.pages.barang.barangpimpinan', ['data' => $data, 'datahp' => $datahp]);
        } else {
            return view('admin/pages/barang/barang', ['data' => $data]);
        }
    }
    public function detail($id)
    {
        if (Gate::allows('isAdmin')) {
            $barang = barang::find($id);
            $riwayatpeminjaman = transaksi::where('barang_id', $id)->get();
            $riwayatpindah = pemindahaninventaris::where('barang_id', $id)->get();
            return view('admin/pages/barang/barangdetail', [
                'barang' => $barang,
                'riwayatpeminjaman' => $riwayatpeminjaman,
                'riwayatpindah' => $riwayatpindah
            ]);
        } elseif (Gate::allows('isUser')) {
            $barang = barang::find($id);
            $pengajuanpeminjaman = pengajuanpeminjaman::where('barang_id', $id)->where('user_id', Auth::id())->where('status', 'Sedang Diajukan')->first();
            $barang->statuspengajuan = 0;
            if ($pengajuanpeminjaman) {
                $barang->statuspengajuan = 1;
            }
            return view('user/pages/barang/barangdetail', [
                'barang' => $barang
            ]);
        } else {
            return redirect('/');
        }
    }


    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = jenisbarang::all();
        $satuan = satuan::all();
        return view('admin.pages.barang.barangcreate', ['data' => $data], ['satuan' => $satuan]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'kodebarang' => 'required|max:255|unique:barangs',
            'namabarang' => 'required|max:255',
            'jenisbarang_id' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'kondisi' => 'required|max:255',
            'tahunpengadaan' => 'required',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

            $path = $file->storeAs('fotobarang', $namaFileBaru, 'public');

            $validatedData['foto'] = $path;
        } else {
            $validatedData['foto'] = "-";
        }

        $barcodePNG = DNS1DFacade::getBarcodePNG($validatedData['kodebarang'], 'C128');

        if ($barcodePNG !== false) {
            // Generate unique filename untuk gambar barcode
            $namaFilePNG = 'barcode_' . $validatedData['kodebarang'] . '.png';

            // Simpan konten gambar barcode PNG ke dalam storage/app/public/barcodebarang
            $path = storage_path('app/public/barcodebarang/' . $namaFilePNG);

            // Simpan gambar ke dalam path yang telah dibuat
            file_put_contents($path, base64_decode($barcodePNG));

            // Path ke file gambar barcode yang disimpan di storage
            $path = 'barcodebarang/' . $namaFilePNG;

            // Set path gambar barcode ke dalam data yang divalidasi
            $validatedData['barcode'] = $path;
        } else {
            $validatedData['barcode'] = '-';
        }



        $validatedData['stock'] = 1;
        $tambahbarang = barang::create($validatedData);

        if ($tambahbarang) {
            $tambah = JenisBarang::where('id', $validatedData['jenisbarang_id'])->increment('jumlahbarang', 1);
            // logaktivitas::create([
            //     'user_id'=>auth::id(),
            //     'aktivitas' => 'Menambahkan data barang dengan kode barang = '.$tambahbarang->kodebarang
            // ]);
            return redirect('admin/barang')->with('success', 'Data created successfully');
        } else {
            return redirect('admin/barang')->with('failed', 'Data created failed');
        }
    }
    public function edit(barang $barang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = jenisbarang::all();
        $satuan = satuan::all();
        return view('admin.pages.barang.barangedit', [
            'barang' => $barang,
            'data' => $data,
            'satuan' => $satuan
        ]);
    }

    public function update(Request $request, barang $barang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'kodebarang' => 'required|max:255|unique:barangs,kodebarang,' . $barang->id,
            'namabarang' => 'required|max:255',
            'jenisbarang_id' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $barang->foto);
            if (file_exists($path)) {
                unlink($path);
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

            $path = $file->storeAs('fotobarang', $namaFileBaru, 'public');

            $validatedData['foto'] = $path;
        } else {
            if ($validatedData['kodebarang'] != $barang->kodebarang) {

                $namaFotoLama = $barang->foto;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/fotobarang/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);


                $validatedData['foto'] = 'fotobarang/' . $namaFileBaru;
            } else {
                $cek = barang::find($barang->id);
                $validatedData['foto'] = $cek->foto;
            }
        }

        $barcodePNG = DNS1DFacade::getBarcodePNG($validatedData['kodebarang'], 'C128');

        if ($barcodePNG !== false) {
            $path = storage_path('app/public/' . $barang->barcode);
            if (file_exists($path)) {
                unlink($path);
            }
            // Generate unique filename untuk gambar barcode
            $namaFilePNG = 'barcode_' . $validatedData['kodebarang'] . '.png';

            // Simpan konten gambar barcode PNG ke dalam storage/app/public/barcodebarang
            $path = storage_path('app/public/barcodebarang/' . $namaFilePNG);

            // Simpan gambar ke dalam path yang telah dibuat
            file_put_contents($path, base64_decode($barcodePNG));

            // Path ke file gambar barcode yang disimpan di storage
            $path = 'barcodebarang/' . $namaFilePNG;

            // Set path gambar barcode ke dalam data yang divalidasi
            $validatedData['barcode'] = $path;
        } else {
            $validatedData['barcode'] = '-';
        }



        $ubahdata = $barang->update($validatedData);
        if (!$ubahdata) {
            return redirect('admin/barang')->with('failed', 'Data gagal diupdate');
        }
        $barang = barang::find($barang->id);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mengubah data barang dengan kode barang = ' . $barang->kodebarang
        ]);
        return redirect('admin/barang')->with('success', 'Data has been updated');
    }
    public function print()
    {
        $item = barang::all();

        return view('admin.pages.barang.printbarcode', compact('item'));
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barang::findOrFail($id);

        if ($data->foto != "-") {
            $path = storage_path('app/public/' . $data->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        if ($data->barcode != "-") {
            $path = storage_path('app/public/' . $data->barcode);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $penempatan = penempatan::where('barang_id', $id)->delete();
        pemindahaninventaris::where('barang_id', $id)->delete();
        $transaksi = transaksi::where('barang_id', $id)->where('status', 'Sedang Dipinjam')->first();
        if ($transaksi) {
            return redirect('admin/barang')->with('Failed', 'Barang ini masih di pinjam');
        } else {
            transaksi::where('barang_id', $id)->delete();
        }

        $cek = $data->delete();
        if ($cek) {
            $kurang = JenisBarang::find($data->jenisbarang_id)->decrement('jumlahbarang', 1);
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Mengapus data barang dengan kode barang = ' . $data->kodebarang
            ]);
            return redirect('admin/barang')->with('success', 'Data has Been Deleted');
        } else {
            return redirect('admin/barang')->with('failed', 'Data Not Deleted');
        }
    }

    public function barangpinjam()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barang::where('sifatbarang', 'Boleh Dipinjam')->get();
        return view('/admin/pages/barang/barangpinjam', ['data' => $data]);
    }

    public function barangrusak()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barang::where('kondisi', 'Rusak')->get();
        return view('/admin/pages/barang/barangrusak', ['data' => $data]);
    }

    public function tambahbarangpinjam(request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $cek = barang::where('kodebarang', $request->kodebarang)->first();
        if (!$cek) {
            return redirect('admin/barangpinjam')->with('Failed', 'Data dengan kode barang tersebut tidak ditemukan');
        }
        $cek->update(['sifatbarang' => 'Boleh Dipinjam']);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mengubah data barang dengan kode barang = ' . $cek->kodebarang . ' sebagai barang yang boleh dipinjam'
        ]);
        return redirect('admin/barangpinjam')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function tambahbarangrusak(request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $cek = barang::where('kodebarang', $request->kodebarang)->first();
        if (!$cek) {
            return redirect('admin/barangpinjam')->with('Failed', 'Data dengan kode barang tersebut tidak ditemukan');
        }
        $cek->update(['kondisi' => 'Rusak']);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mengubah data barang dengan kode barang = ' . $cek->kodebarang . ' sebagai barang yang rusak'
        ]);
        return redirect('admin/barangpinjam')->with('success', 'Data Berhasil Ditambahkan');
    }


    public function barangpinjamhapus($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $ubahdata = barang::where('id', $id)->update(['sifatbarang' => 'Tidak Boleh Dipinjam']);
        if (!$ubahdata) {
            return redirect('admin/barangpinjam')->with('Failed', 'Data gagal dihapus');
        }
        $ubahdata = barang::find($id);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menghapus data barang dengan kode barang = ' . $ubahdata->kodebarang . ' sebagai barang yang boleh dipinjam'
        ]);
        return redirect('admin/barangpinjam')->with('success', 'Data Berhasil Dihapus');
    }

    public function barangrusakhapus($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $ubahdata = barang::where('id', $id)->update(['kondisi' => 'Baik']);
        if (!$ubahdata) {
            return redirect('admin/barangpinjam')->with('Failed', 'Data gagal dihapus');
        }
        $ubahdata = barang::find($id);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menghapus data barang dengan kode barang = ' . $ubahdata->kodebarang . ' sebagai barang yang rusak'
        ]);
        return redirect('admin/barangpinjam')->with('success', 'Data Berhasil Dihapus');
    }

    public function exportbarang()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barang::all();
        return view('admin.pages.barang.barangekspor', ['data' => $data]);
    }
}