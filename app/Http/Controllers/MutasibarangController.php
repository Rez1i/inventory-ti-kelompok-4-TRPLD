<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\barang;
use App\Models\transaksi;
use App\Models\penempatan;
use App\Models\logaktivitas;
use App\Models\mutasibarang;
use Illuminate\Http\Request;
use App\Models\dmutasibarang;
use App\Models\pengajuanpeminjaman;
use App\Models\pemindahaninventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class MutasibarangController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = mutasibarang::where('status', '-')->delete();
        $data = mutasibarang::all();
        return view('admin/pages/mutasibarang/mutasibarang', ['data' => $data]);
    }
    public function downloadcontoh()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return response()->download(public_path('storage/contohfileimport/barangmutasiimport.xlsx'));
    }
    public function process(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $barang = barang::all();
        $mutasibarang = mutasibarang::find($request->mutasi_id);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $successCount = 0;
        $errorMessages = [];

        foreach ($sheet->getRowIterator() as $row) {
            // Skip header row
            if ($row->getRowIndex() == 1) {
                continue;
            }

            $rowData = [];

            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Validasi data
            $validator = Validator::make(['kodebarang' => $rowData[1]], ['kodebarang' => 'required|max:255']);

            if ($validator->fails()) {
                continue;
            }

            $cek = $barang->where('kodebarang', $rowData[1])->first();
            if (!$cek) {
                continue;
            }
            $tambah = dmutasibarang::create([
                'mutasi_id' => $request->mutasi_id,
                'kodebarang' => $cek->kodebarang,
                'namabarang' => $cek->namabarang
            ]);
            if (!$tambah) {
                continue;
            }
            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambahkan data barang yang dimutasi dengan kode barang' . $tambah->koebarang
            ]);
            $mutasibarang->increment('banyakbarang', 1);
            $mutasibarang->update(['status' => 'Proses']);
            pemindahaninventaris::where('barang_id', $cek->id)->delete();
            penempatan::where('barang_id', $cek->id)->delete();
            transaksi::where('barang_id', $cek->id)->delete();
            $cek->delete();

            $successCount++;
        }
        if ($successCount > 0) {
            return redirect('admin/barangmutasi/' . $request->mutasi_id)->with('success', 'Data barang berhasil diimpor.');
        } else {
            return redirect('admin/barangmutasi/' . $request->mutasi_id)->with('Failed', 'Tidak ada data barang yang berhasil diimpor.')->withErrors($errorMessages);
        }
    }
    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return view('admin/pages/mutasibarang/mutasibarangcreate');
    }

    public function databarang($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }

        $mutasibarang = mutasibarang::find($id);
        $data = dmutasibarang::where('mutasi_id', $id)->get();
        return view('admin/pages/mutasibarang/databarangmutasi', ['data' => $data], ['mutasibarang' => $mutasibarang]);
    }
    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        if ($request->inputan == "databarangmutasi") {
            $validatedData = $request->validate([
                'alasan' => 'required',
                'penanggungjawab' => 'required|email',
                'laporan' => 'nullable|mimes:pdf|max:2048'
            ]);

            $user = User::where('email', $validatedData['penanggungjawab'])->first();
            if (!$user) {
                return back()->with('Failed', 'Penanggung jawab tidak terdaftar di sistem');
            }

            if ($request->file('laporan')) {
                $file = $request->file('laporan');
                $extension = $file->getClientOriginalExtension();
                $namaFileBaru = 'laporan_mutasi_barang_' . $validatedData['penanggungjawab'] . '.' . $extension;

                $path = $file->storeAs('laporan_mutasi_barang', $namaFileBaru, 'public');

                $validatedData['laporan'] = $path;
                $validatedData['status'] = 'Selesai';
            } else {
                $validatedData['laporan'] = "-";
                $validatedData['status'] = 'Belum Selesai';
            }

            $tambahdata = mutasibarang::create($validatedData);
            if (!$tambahdata) {
                return back()->with('Failed', 'Data gagal ditambahkan');
            }

            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambahkan data mutasi barang dengan id ' . $tambahdata->id
            ]);

            return redirect("/admin/barangmutasi/{$tambahdata->id}");
        } else {
            $validatedData = $request->validate([
                'kodebarang' => 'required|max:255'
            ]);

            $barang = Barang::where('kodebarang', $validatedData['kodebarang'])->first();
            if (!$barang) {
                return back()->with('Failed', 'Barang tidak ditemukan');
            }

            $validatedData['mutasi_id'] = $request->id;
            $validatedData['namabarang'] = $barang->namabarang;

            $tambah = Dmutasibarang::create($validatedData);
            if (!$tambah) {
                return back()->with('Failed', 'Barang gagal ditambahkan');
            }

            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambahkan data barang yang dimutasi dengan kode barang ' . $tambah->kodebarang
            ]);

            $mutasibarang = Mutasibarang::find($request->id);
            $mutasibarang->increment('banyakbarang', 1);
            $mutasibarang->update(['status' => 'Proses']);

            Pemindahaninventaris::where('barang_id', $barang->id)->delete();
            Penempatan::where('barang_id', $barang->id)->delete();
            Transaksi::where('barang_id', $barang->id)->delete();
            pengajuanpeminjaman::where('barang_id', $barang->id)->delete();

            Barang::where('kodebarang', $validatedData['kodebarang'])->delete();

            return back()->with('success', 'Data berhasil ditambahkan');
        }
    }
    public function downloadlaporan($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $barangmasuk = mutasibarang::find($id);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mendownload laporan mutasi barang dengan id = ' . $id
        ]);
        return response()->download(public_path('storage/' . $barangmasuk->laporan));
    }
}
