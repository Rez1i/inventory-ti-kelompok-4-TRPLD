<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use App\Models\penempatan;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\pemindahaninventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
        public function index()
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $data = ruangan::all(); 
            return view('admin/pages/ruangan/ruangan', ['data' => $data]); 
    
        }
        
        public function create()
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            return view('admin.pages.ruangan.ruangancreate');
        }

        public function downloadcontoh(){
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            return response()->download(public_path('storage/contohfileimport/ruanganimport.xlsx'));
        }
        public function process(Request $request)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
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
                    'nama_ruangan' => $rowData[1],
                    'keterangan' => $rowData[2]
                ], [
                    'nama_ruangan'=> 'required|max:255|unique:ruangans',
                    'keterangan'=> 'required'
                ]);
    
                if ($validator->fails()) {
                    continue;
                }
                
                $tambahdata=ruangan::create([
                    'nama_ruangan' => $rowData[1],
                    'keterangan' => $rowData[2]
                ]);
                if(!$tambahdata){
                    continue;
                }
                logaktivitas::create([
                    'user_id'=> Auth::id(),
                    'aktivitas' => 'Menambahkan data ruangan dengan id'.$tambahdata->id
                ]);   
                
                $successCount++;
            }
    
            if ($successCount > 0) {
                return redirect('admin/ruangan/import')->with('success', 'Data ruangan berhasil diimpor.');
            } else {
                return redirect('admin/ruangan/import')->with('Failed', 'Tidak ada data ruangan yang valid diimpor.')->withErrors($errorMessages);
            }
        }
    
        public function store(Request $request)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $validatedData = $request->validate([
                'nama_ruangan'=> 'required|max:255',
                'keterangan'=> 'required|max:255'
            ]);
        
            $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
        
            $tambahdata= ruangan::create($validatedData);
            if(!$tambahdata){
                return redirect('admin/ruangan')->with('Failed', 'Data gagal ditambahakan');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data ruangan dengan id'.$tambahdata->id
            ]);   
            return redirect('admin/ruangan')->with('success', 'Data created successfully');
        }
        public function edit(ruangan $ruangan)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            return view('admin.pages.ruangan.ruanganedit',['ruangan'=>$ruangan]);
        }
    
        public function update(Request $request, ruangan $ruangan)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $validatedData = $request->validate([
                'nama_ruangan'=> 'required|max:255',
                'keterangan'=> 'required|max:255'
            ]);
                $editdata= ruangan::where('id', $ruangan->id)->update($validatedData);
                if(!$editdata){
                    return redirect('admin/ruangan')->with('Failed', 'Data gagal diubah');
                }
                logaktivitas::create([
                    'user_id'=> Auth::id(),
                    'aktivitas' => 'Mengubah data ruangan dengan id'.$editdata->id
                ]);  
                return redirect('admin/ruangan')->with('success', 'Data has been update');
                
        }
        public function destroy($id)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $data = ruangan::findOrFail($id);
            $penempatan= penempatan::where('ruangan_id', $data->id)->first();
            if($penempatan){
                return redirect('admin/ruangan')->with('Failed', 'Masih Ada data barang yang ditempatkan di '. $data->nama_ruangan);
            }
            pemindahaninventaris::where('ruanganasal_id',$id)->OrWhere('ruangantujuan_id',$id)->delete();
            $hapusdata=$data->delete();
            if(!$hapusdata){
                return redirect('admin/ruangan')->with('Failed', 'Data gagal dihapus');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menghapus data ruangan dengan id'.$id
            ]);  
            return redirect('admin/ruangan')->with('success', 'Data has Been Deleted');
        }
}
    

