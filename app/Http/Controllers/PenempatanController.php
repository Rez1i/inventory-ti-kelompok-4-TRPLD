<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\ruangan;
use App\Models\penempatan;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\pemindahaninventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class PenempatanController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = penempatan::all(); 
        return view('admin/pages/penempatan/penempatan', ['data' => $data]); 
    }

    public function create(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = ruangan::all(); 
        return view('admin/pages/penempatan/penempatancreate', ['data' => $data]); 
    }

    public function downloadcontoh(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return response()->download(public_path('storage/contohfileimport/penempatanimport.xlsx'));
    }
    public function process(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $barang = barang::all();
        $ruangan = ruangan::all();
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

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
                'namaruangan' => $rowData[2]
            ], [
                'kodebarang'=> 'required',
                'namaruangan'=> 'required'
            ]);

            if ($validator->fails()) {
                continue;
            }

            $cekbarang= $barang->where('kodebarang',$rowData[1])->first();
            $cekruangan = $ruangan->where('nama_ruangan',$rowData[2])->first();
            if(!$cekruangan || !$cekbarang){
                continue;
            }
            
            $tambah=penempatan::create([
                'barang_id' => $cekbarang->id,
                'ruangan_id' => $cekruangan->id
            ]);
            if(!$tambah){
                continue;
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data penempatan barang dengan id'.$tambah->id
            ]);   
            
            $successCount++;
        }

        if ($successCount > 0) {
            return redirect('admin/penempatan/import')->with('success', 'Data Penempatan Barang berhasil diimpor.');
        } else {
            return redirect('admin/penempatan/import')->with('Failed', 'Tidak ada data Penempatan Barang  yang valid diimpor.')->withErrors($errorMessages);
        }
    }

    public function store(request $request){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validateddata=$request->validate([
            'kodebarang'=> 'required|max:255',
            'ruangan_id'=> 'required|max:255'
        ]);

        $barang=barang::where('kodebarang',$validateddata['kodebarang'])->first();
            if(!$barang){
                return redirect('/admin/penempatan')->with('failed','Data barang tidak ditemukan di sistem');
            }
            if($barang->sifatbarang == "Boleh Dipinjam"){
                return redirect('/admin/penempatan')->with('failed','Barang Ini merupakan Barang yang sering dipinjam');
            }
            $validateddata['barang_id']=$barang->id;

            $tambah = penempatan::create($validateddata);
            if(!$tambah){
                return redirect('/admin/penempatan')->with('failed','Data gagal ditambahkan');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data penempatan barang dengan id'.$tambah->id
            ]);   
            $ruangan = ruangan::find($validateddata['ruangan_id']);
            $barang->update(['status' => 'Barang ditempatkan di ' . $ruangan->nama_ruangan]);
            return redirect('/admin/penempatan')->with('success','Data Berhasil Ditambahkan');
    }

    public function edit(penempatan $penempatan){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $barang = barang::find($penempatan->barang_id);
        $penempatan->kodebarang=$barang->kodebarang;
        $data = ruangan::all(); 
        return view('admin/pages/penempatan/penempatanedit', ['data' => $data],['penempatan'=>$penempatan]); 

    }
    public function update(request $request,penempatan $penempatan){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validateddata=$request->validate([
            'kodebarang'=> 'required|max:255',
            'ruangan_id'=> 'required|max:255'
        ]);

        if($penempatan->ruangan_id != $validateddata['ruangan_id']){
            $validateddata=$request->validate([
                'kodebarang'=> 'required|max:255',
                'ruangan_id'=> 'required|max:255',
                'alasan' => 'required'
            ]);

            $barang=barang::where('kodebarang',$validateddata['kodebarang'])->first();
            if(!$barang){
                return redirect('/admin/penempatan')->with('failed','Data barang tidak ditemukan di sistem');
            }
            $validateddata['barang_id']=$barang->id;

            $validateddata['ruanganasal_id'] = $penempatan->ruangan_id;
            $validateddata['ruangantujuan_id'] = $validateddata['ruangan_id'];
            $validateddata['penanggungjawab_id'] = auth::id();
            $validateddata['alasan'] = strip_tags($validateddata['alasan']);

            pemindahaninventaris::create($validateddata);
        }

        $editdata= $penempatan->update($validateddata);
            if(!$editdata){
                return redirect('/admin/penempatan')->with('failed','Data gagal ditambahkan');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Mengubah data penempatan barang dengan id'.$editdata->id
            ]);   
        $ruangan = ruangan::find($validateddata['ruangan_id']);
        $barang->update(['status' => 'Barang ditempatkan di ' . $ruangan->nama_ruangan]);
        return redirect('/admin/penempatan')->with('success','Data Berhasil Ditambahkan');
    }

    public function destroy($id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = penempatan::findOrFail($id);
        $hapusdata = $data->delete();
        if(!$hapusdata){
            return redirect('/admin/penempatan')->with('failed','Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menghapus data penempatan barang dengan id'.$id
        ]);   
        $barang=barang::find($data->barang_id);
        $barang->update(['status' => 'Tersedia']);
        return redirect('admin/penempatan')->with('success', 'Data has Been Deleted');
    }
}
