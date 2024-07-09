<?php

namespace App\Http\Controllers;

use App\Models\satuan;
use App\Models\baranghp;
use Milon\Barcode\Facades\DNS2DFacade;
use App\Models\barangkeluar;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\kategoribarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Milon\Barcode\Facades\DNS1DFacade;

class BaranghpController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }

        $data = baranghp::all();
        $barcodes = [];

        foreach ($data as $item) {
            // Generate barcode HTML for each item and store in an array
            $barcodes[$item->id] = DNS2DFacade::getBarcodeHTML($item->kodebarang, 'QRCODE');
        }

        return view('admin.pages.baranghp.baranghp', [
            'data' => $data,
            'barcodes' => $barcodes,
        ]);
    }
    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = kategoribarang::all();
        $satuan = satuan::all();
        return view('admin.pages.baranghp.baranghpcreate', ['data' => $data], ['satuan' => $satuan]);
    }

    public function detail($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $baranghp = baranghp::find($id);
        $riwayattransaksi = barangkeluar::where('barangkeluar_id', $id)->get();
        return view('admin/pages/baranghp/baranghpdetail', ['baranghp' => $baranghp], ['riwayattransaksi' => $riwayattransaksi]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'kodebarang' => 'required|max:255|unique:barangs|unique:baranghps',
            'namabarang' => 'required|max:255',
            'kategoribarang_id' => 'required|max:255',
            'tahunpengadaan' => 'required',
            'stock' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

            $path = $file->storeAs('fotobaranghp', $namaFileBaru, 'public');

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

        $tambahbaranghp = baranghp::create($validatedData);

        if ($tambahbaranghp) {
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Menambahkan data barang habis pakai dengan kode barang = ' . $tambahbaranghp->kodebarang
            ]);
            return redirect('admin/baranghp')->with('success', 'Data created successfully');
        } else {
            return redirect('admin/baranghp')->with('failed', 'Data created failed');
        }
    }
    public function edit(baranghp $baranghp)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = kategoribarang::all();
        $satuan = satuan::all();
        return view('admin.pages.baranghp.baranghpedit', [
            'baranghp' => $baranghp,
            'data' => $data,
            'satuan' => $satuan
        ]);
    }

    public function update(Request $request, baranghp $baranghp)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'kodebarang' => 'required|max:255|unique:baranghps,kodebarang,' . $baranghp->id, '|unique:barangs',
            'namabarang' => 'required|max:255',
            'kategoribarang_id' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'stock' => 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $baranghp->foto);
            if (file_exists($path)) {
                unlink($path);
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

            $path = $file->storeAs('fotobaranghp', $namaFileBaru, 'public');

            $validatedData['foto'] = $path;
        } else {
            if ($validatedData['kodebarang'] != $baranghp->kodebarang) {

                $namaFotoLama = $baranghp->foto;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['kodebarang'] . '.' . $extension;

                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/fotobaranghp/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);


                $validatedData['foto'] = 'fotobarang/' . $namaFileBaru;
            } else {
                $cek = baranghp::find($baranghp->id);
                $validatedData['foto'] = $cek->foto;
            }

            $barcodePNG = DNS1DFacade::getBarcodePNG($validatedData['kodebarang'], 'C128');

            if ($barcodePNG !== false) {
                $path = storage_path('app/public/' . $baranghp->barcode);
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
        }

        $editdata = $baranghp->update($validatedData);

        if ($editdata) {
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Mengubah data barang habis pakai dengan kode barang = ' . $baranghp->kodebarang
            ]);
            return redirect('admin/baranghp')->with('success', 'Data has been updated');
        } else {
            return redirect('admin/baranghp')->with('failed', 'Data has not been updated');
        }
    }
    public function print()
    {
        $item = baranghp::all();

        return view('admin.pages.baranghp.printbarcode', compact('item'));
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = baranghp::findOrFail($id);
        $barangkeluar = barangkeluar::where('barangkeluar_id', $id)->delete();

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

        $hapus = $data->delete();
        if ($hapus) {
            logaktivitas::create([
                'user_id' => auth::id(),
                'aktivitas' => 'Menghapus data barang habis pakai dengan kode barang = ' . $data->kodebarang
            ]);
            return redirect('admin/baranghp')->with('success', 'Data has Been Deleted');
        } else {
            return redirect('admin/baranghp')->with('failed', 'Data Not Deleted');
        }
    }
    public function exportbaranghp()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = baranghp::all();
        return view('admin.pages.baranghp.baranghpekspor', ['data' => $data]);
    }
}
