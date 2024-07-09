<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\satuan;
use App\Models\dbmasuk;
use App\Models\baranghp;
use App\Models\barangmasuk;
use App\Models\jenisbarang;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\kategoribarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BaranghpController;

class BarangmasukController extends Controller
{
    protected $BarangController;
    protected $BaranghpController;

    public function __construct(BarangController $BarangController, Baranghpcontroller $BaranghpController)
    {
        $this->BarangController = $BarangController;
        $this->BaranghpController = $BaranghpController;
    }


    public function index()
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        $data = barangmasuk::where('stock', 0)->first();
        if ($data) {
            $path = storage_path('app/public/' . $data->laporan);
            if (file_exists($path)) {
                unlink($path);
            }
            $data->delete();
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Batal menambahkan barang masuk'
            ]);
        }
        $data = barangmasuk::all();
        return view('admin/pages/barangmasuk/barangmasuk', ['data' => $data]);
    }

    public function inputbarang($id)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        $barangmasuk = BarangMasuk::find($id);
        $detail = dbmasuk::where('barangmasuk_id', $id)->get();
        return view('admin/pages/barangmasuk/inputbarangmasuk', [
            'detail' => $detail,
            'barangmasuk' => $barangmasuk
        ]);
    }
    public function tambahbarang()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return view('/admin/pages/barangmasuk/tambahbarangmasuk');
    }

    public function downloadlaporan($id)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isPimpinan')) {
            return redirect('/');
        }
        $barangmasuk = barangmasuk::find($id);
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mendownload laporan barang masuk dengan id = ' . $id
        ]);
        return response()->download(public_path('storage/' . $barangmasuk->laporan));
    }



    public function barangmasuk($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $barangmasuk = BarangMasuk::find($id);
        $data = JenisBarang::all();
        $satuan = Satuan::all();
        return view('admin.pages.barangmasuk.barangmasukcreate', [
            'data' => $data,
            'satuan' => $satuan,
            'barangmasuk' => $barangmasuk
        ]);
    }

    public function baranghpmasuk($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $barangmasuk = barangmasuk::find($id);
        $data = kategoribarang::all();
        $satuan = satuan::all();
        return view('admin.pages.barangmasuk.baranghpmasukcreate', [
            'data' => $data,
            'satuan' => $satuan,
            'barangmasuk' => $barangmasuk
        ]);
    }

    public function downloadcontoh()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return response()->download(public_path('storage/contohfileimport/barangmasukimport.xlsx'));
    }
    public function process(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $kategoribarang = kategoribarang::all();
        $jenisbarang = jenisbarang::all();
        $satuan = satuan::all();


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
            $validator = Validator::make([
                'kodebarang' => $rowData[1],
                'namabarang' => $rowData[2],
                'jenisbarang' => $rowData[3],
                'kategoribarang' => $rowData[4],
                'kondisibarang' => $rowData[5],
                'stock' => $rowData[6],
                'namasatuan' => $rowData[7],
                'kelompokbarang' => $rowData[8]
            ], [
                'kodebarang' => 'required|max:255|unique:barangs|unique:baranghps',
                'namabarang' => 'required|max:255',
                'jenisbarang' => 'required|max:255',
                'kategoribarang' => 'required|max:255',
                'kondisibarang' => 'required|max:255',
                'stock' => 'required|max:255',
                'namasatuan' => 'required|max:255',
                'kelompokbarang' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                continue;
            }
            $ceksatuan = $satuan->where('nama_satuan', $rowData[7])->first();
            if (!$ceksatuan) {
                continue;
            }

            $barangmasuk = barangmasuk::find($request->barangmasuk_id);

            if ($rowData[8] == "BHP") {
                if ($rowData[6] == "none") {
                    continue;
                }

                $cek = $kategoribarang->where('nama_kategoribarang', $rowData[4])->first();
                if (!$cek) {
                    continue;
                }
                $tambah = baranghp::create([
                    'kodebarang' => $rowData[1],
                    'namabarang' => $rowData[2],
                    'kategoribarang_id' => $cek->id,
                    'tahunpengadaan' => $barangmasuk->tahunpengadaan,
                    'stock' => $rowData[6],
                    'satuan_id' => $ceksatuan->id
                ]);
                if (!$tambah) {
                    continue;
                }
                logaktivitas::create([
                    'user_id' => auth::id(),
                    'aktivitas' => 'Menambahkan data barang habis pakai dengan kode barang = ' . $tambah->kodebarang
                ]);
            } else {
                $cek = $jenisbarang->where('nama_jenisbarang', $rowData[3])->first();
                if (!$cek) {
                    continue;
                }

                $tambah = barang::create([
                    'kodebarang' => $rowData[1],
                    'namabarang' => $rowData[2],
                    'jenisbarang_id' => $cek->id,
                    'stock' => 1,
                    'satuan_id' => $ceksatuan->id,
                    'kondisi' => $rowData[5],
                    'tahunpengadaan' => $barangmasuk->tahunpengadaan
                ]);
                if (!$tambah) {
                    continue;
                }
                logaktivitas::create([
                    'user_id' => auth::id(),
                    'aktivitas' => 'Menambahkan data barang dengan kode barang = ' . $tambah->kodebarang
                ]);
            }

            if ($rowData[6] == 'none') {
                $rowData[6] = 1;
            }

            $dbmasuk = dbmasuk::create([
                'barangmasuk_id' => $barangmasuk->id,
                'kodebarang' => $rowData[1],
                'namabarang' => $rowData[2],
                'banyakbarang' => $rowData[6],
                'satuan_id' => $ceksatuan->id
            ]);
            if ($dbmasuk) {
                logaktivitas::create([
                    'user_id' => auth::id(),
                    'aktivitas' => 'Menambahkan data detail barang masuk dengan kode barang = ' . $dbmasuk->kodebarang
                ]);
                $tambah = barangmasuk::where('id', $barangmasuk->id)->increment('stock', 1);
                $barangmasuk = BarangMasuk::where('id', $barangmasuk->id)->update(['status' => 'Proses']);
            }

            $successCount++;
        }
        if ($successCount > 0) {
            return redirect('admin/inputbarangmasuk/' . $request->barangmasuk_id)->with('success', 'Data barang berhasil diimpor.');
        } else {
            return redirect('admin/inputbarangmasuk/' . $request->barangmasuk_id)->with('Failed', 'Tidak ada data barang yang berhasil diimpor.')->withErrors($errorMessages);
        }
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        if ($request->pemasok) {
            $validatedData = $request->validate([
                'pemasok' => 'required|max:255',
                'tahunpengadaan' => 'required',
                'laporan' => 'mimes:pdf|max:2048'
            ]);

            $validatedData['user_id'] = Auth::id();
            $cek = barangmasuk::where('pemasok', $validatedData['pemasok'])->where('tahunpengadaan', $validatedData['tahunpengadaan'])->first();
            if ($cek) {
                return redirect('/admin/inputbarangmasuk/' . $cek->id);
            }

            if ($request->file('laporan')) {
                $file = $request->file('laporan');
                $extension = $file->getClientOriginalExtension();
                $namaFileBaru = 'laporan barang masuk tahun ' . $validatedData['tahunpengadaan'] . '.' . $extension;

                $path = $file->storeAs('laporan barang masuk', $namaFileBaru, 'public');

                $validatedData['laporan'] = $path;
                $validatedData['status'] = 'Sudah Ada Laporan';
            } else {
                $validatedData['laporan'] = "-";
                $validatedData['status'] = 'Belum Ada Laporan';
            }

            $tambahdata = barangmasuk::create($validatedData);
            if (!$tambahdata) {
                return redirect('/admin/barangmasuk')->with('Failed', 'Data Gagal ditambahkan');
            }
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Menambahkan data barang masuk dengan id = ' . $tambahdata->id
            ]);
            return redirect('/admin/inputbarangmasuk/' . $tambahdata->id);
        } else {
            if ($request->kondisi) {
                $this->BarangController->store($request);
            } else {
                $this->BaranghpController->store($request);
            }

            $validatedData = $request->validate([
                'kodebarang' => 'required|max:255',
                'namabarang' => 'required|max:255',
                'satuan_id' => 'required|max:255'
            ]);
            $validatedData['barangmasuk_id'] = $request->barangmasuk_id;
            $validatedData['banyakbarang'] = $request->stock;
            $dbmasuk = dbmasuk::create($validatedData);
            if ($dbmasuk) {
                logaktivitas::create([
                    'user_id' => auth::id(),
                    'aktivitas' => 'Menambahkan data detail barang masuk dengan kode barang = ' . $dbmasuk->kodebarang
                ]);
                $tambah = barangmasuk::where('id', $validatedData['barangmasuk_id'])->increment('stock', 1);
            }
        }
        return redirect('/admin/inputbarangmasuk/' . $validatedData['barangmasuk_id']);
    }

    public function hapusbarang(request $request, $kodebarang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $deletedbmasuk = dbmasuk::where('kodebarang', $kodebarang)->delete();
        if (!$deletedbmasuk) {
            return back()->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menghapus data detail barang masuk dengan kode barang = ' . $kodebarang
        ]);
        $barang = barang::where('kodebarang', $kodebarang)->first();
        $baranghp = baranghp::where('kodebarang', $kodebarang)->first();

        if ($barang) {
            $this->BarangController->destroy($barang->id);
        } elseif ($baranghp) {
            $this->BaranghpController->destroy($baranghp->id);
        } else {
        }
        barangmasuk::where('id', $request->barangmasuk_id)->decrement('stock', 1);

        return back()->with('success', 'Data Has Ben Deleted');
    }
}
