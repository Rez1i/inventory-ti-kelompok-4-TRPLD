<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\dosen;
use App\Models\staff;
use App\Models\satuan;
use App\Models\baranghp;
use App\Models\mahasiswa;
use App\Models\barangkeluar;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BarangkeluarController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        $data = barangkeluar::where('banyakbarang', 0)->first();
        if ($data) {
            $path = storage_path('app/public/' . $data->laporan);
            if (file_exists($path)) {
                unlink($path);
            }
            $data->delete();
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Batal menambahkan barang keluar'
            ]);
        }
        $data = barangkeluar::all();
        return view('admin/pages/barangkeluar/barangkeluar', ['data' => $data]);
    }
    public function detail($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barangkeluar::find($id);
        return view('admin/pages/barangkeluar/barangkeluardetail', ['data' => $data]);
    }
    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $satuan = satuan::all();
        return view('admin.pages.barangkeluar.barangkeluarcreate', ['satuan' => $satuan]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'penerima' => 'required|email:dns|max:255',
            'kodebarang' => 'required|max:255',
            'banyakbarang' => 'required',
            'tujuan' => 'required'
        ]);

        $cek = user::where('email', $validatedData['penerima'])->first();
        $cekmahasiswa = mahasiswa::where('email', $validatedData['penerima'])->orwhere('nim', $validatedData['penerima'])->first();
        $cekdosen = dosen::where('email', $validatedData['penerima'])->orwhere('nip', $validatedData['penerima'])->first();
        $cekstaff = staff::where('email', $validatedData['penerima'])->orwhere('nik', $validatedData['penerima'])->first();
        if (!$cek && $cekmahasiswa && $cekdosen && $cekstaff) {
            return back()->with('Failed', 'Email Tidak terdaftar di sistem');
        }

        $barang = baranghp::where('kodebarang', $validatedData['kodebarang'])->first();
        if (!$barang) {
            return back()->with('Failed', 'Barang Tidak terdaftar di sistem');
        }
        $validatedData['satuan_id'] = $barang->satuan_id;
        $validatedData['barangkeluar_id'] = $barang->id;
        $validatedData['user_id'] = auth::id();
        $validatedData['tujuan'] = strip_tags($validatedData['tujuan']);


        $input = barangkeluar::create($validatedData);
        if (!$input) {
            return redirect('/admin/barangkeluar')->with('Failed', 'Transaksi Gagal');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menambahkan data barang keluar dengan id = ' . $input->id
        ]);
        baranghp::where('id', $barang->id)->decrement('stock', $validatedData['banyakbarang']);
        return redirect('/admin/barangkeluar')->with('success', 'Data Berhasil Ditambahkan');
    }
    public function edit(barangkeluar $barangkeluar)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $satuan = satuan::all();
        return view('admin.pages.barangkeluar.barangkeluaredit', ['satuan' => $satuan], ['barangkeluar' => $barangkeluar]);
    }
    public function update(request $request, barangkeluar $barangkeluar)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'penerima' => 'required|email:dns|max:255',
            'kodebarang' => 'required|max:255',
            'banyakbarang' => 'required',
            'tujuan' => 'required'
        ]);

        $cek = user::where('email', $validatedData['penerima'])->first();
        $cekmahasiswa = mahasiswa::where('email', $validatedData['penerima'])->orwhere('nim', $validatedData['penerima'])->first();
        $cekdosen = dosen::where('email', $validatedData['penerima'])->orwhere('nip', $validatedData['penerima'])->first();
        $cekstaff = staff::where('email', $validatedData['penerima'])->orwhere('nik', $validatedData['penerima'])->first();
        if (!$cek && $cekmahasiswa && $cekdosen && $cekstaff) {
            return back()->with('Failed', 'Email Tidak terdaftar di sistem');
        }
        $barang = baranghp::where('kodebarang', $validatedData['kodebarang'])->first();
        if (!$barang) {
            return redirect('/admin/barangkeluar')->with('Failed', 'Barang Tidak terdaftar di sistem');
        }

        $validatedData['satuan_id'] = $barang->satuan_id;
        $validatedData['barangkeluar_id'] = $barang->id;
        $validatedData['user_id'] = auth::id();
        $validatedData['tujuan'] = strip_tags($validatedData['tujuan']);

        $barang->increment('stock', $barangkeluar->banyakbarang);

        $input = $barangkeluar->update($validatedData);
        if (!$input) {
            return redirect('/admin/barangkeluar')->with('Failed', 'Transaksi Gagal');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mengubah data barang keluar dengan id = ' . $barangkeluar->id
        ]);
        baranghp::where('id', $barang->id)->decrement('stock', $validatedData['banyakbarang']);
        return redirect('/admin/barangkeluar')->with('success', 'Data Berhasil Ditambahkan');
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barangkeluar::findOrFail($id);
        $hapus = $data->delete();
        if ($hapus) {
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Menghapus data barang keluar dengan id = ' . $id
            ]);
            baranghp::where('id', $data->barangkeluar_id)->increment('stock', $data->banyakbarang);
            return redirect('admin/barangkeluar')->with('success', 'Data has Been Deleted');
        }
        return redirect('admin/baranghp')->with('Failed', 'Data Not Deleted');
    }

    public function exportbarangkeluar()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = barangkeluar::all();
        return view('admin.pages.barangkeluar.barangkeluarekspor', ['data' => $data]);
    }
}
