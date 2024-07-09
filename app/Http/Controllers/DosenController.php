<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\user;
use App\Models\dosen;
use App\Models\prodi;
use App\Models\jabatan;
use App\Exports\DosenExport;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = dosen::all();
        return view('admin/pages/dosen/dosen', ['data' => $data]); 

    }

    public function sinkrondata(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=dosen&file=index');

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['list'] as $index => $item) {
                $validator = Validator::make([
                    'nama' => $item['nama'],
                    'nip' =>$item['nip'],
                    'email' => $item['email']
                ], [
                    'nama'=> 'required|max:255',
                    'nip'=> 'required|max:255|unique:dosens',
                    'email'=> 'required|email|max:255|unique:dosens|unique:mahasiswas|unique:staffs'
                ]);
    
                if ($validator->fails()) {
                    continue;
                }

                $tambahdata= Dosen::create([
                    'nama' => $item['nama'],
                    'nip' => $item['nip'],
                    'email' => $item['email'],
                    'no_telp' => '-'
                ]);
    
                if(!$tambahdata){
                    continue;
                }
                logaktivitas::create([
                    'user_id'=>Auth::id(),
                    'aktivitas' => 'Menambah data dosen dengan id = '.$tambahdata->id
                ]);  
            }
            return back()->with('success','Data Berhasil di Sinkronisasi'); 
        }else{
            return redirect('admin/dosen')->with('Failed', 'Data gagal di Sinkronisasi');
        }
    }

    public function detail(dosen $dosen, $id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $dosen=dosen::find($id);
        return view('admin/pages/dosen/dosendetail',['dosen'=>$dosen]);

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
                'nama' => $rowData[1],
                'nip' => $rowData[2],
                'email' => $rowData[3],
                'no_telp' => $rowData[4]
            ], [
                'nama'=> 'required|max:255',
                'nip'=> 'required|max:255|unique:dosens',
                'email'=> 'required|email|max:255|unique:dosens|unique:mahasiswas|unique:staffs',
                'no_telp'=> 'required|max:255'
            ]);

            if ($validator->fails()) {
                continue;
            }
            

            // Validasi berhasil, simpan data ke dalam basis data
            $tambahdata= Dosen::create([
                'nama' => $rowData[1],
                'nip' => $rowData[2],
                'email' => $rowData[3],
                'no_telp' => $rowData[4]
            ]);

            if(!$tambahdata){
                continue;
            }
            logaktivitas::create([
                'user_id'=>Auth::id(),
                'aktivitas' => 'Menambah data dosen dengan id = '.$tambahdata->id
            ]);  
            
            $successCount++;
        }

        if ($successCount > 0) {
            return redirect('admin/dosen/import')->with('success', 'Data Dosen berhasil diimpor.');
        } else {
            return redirect('admin/dosen/import')->with('Failed', 'Tidak ada data Dosen yang valid diimpor.')->withErrors($errorMessages);
        }
    }
    public function export()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return Excel::download(new DosenExport, 'Dosen.xlsx');
    }

    public function downloadcontoh(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return response()->download(public_path('storage/contohfileimport/dosenimport.xlsx'));
    }
    
    
    public function create(dosen $dosen)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
         return view('admin/pages/dosen/dosencreate',['dosen'=>$dosen]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama'=> 'required|max:255',
            'nip'=> 'required|max:255|unique:dosens',
            'email'=> 'required|max:255|unique:dosens|unique:mahasiswas|unique:staffs',
            'no_telp'=> 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotodosen',$namaFileBaru, 'public');

            $validatedData['foto']=$path;
        }
        else{
            $validatedData['foto']="-";
        }

        $tambahdata= dosen::create($validatedData);
        if(!$tambahdata){
            return back()->with('Failed', 'Data gagal ditambahkan');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menambah data dosen dengan id = '.$tambahdata->id
        ]);  
        return redirect('admin/dosen')->with('success', 'Data created successfully');
    }

    public function edit(dosen $dosen)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin/pages/dosen/dosenedit',['dosen'=>$dosen]);
    }
    public function update(Request $request, dosen $dosen)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|max:255|unique:dosens,nip,' . $dosen->id,
            'email' => 'required|max:255|unique:dosens,email,' . $dosen->id . '|unique:mahasiswas|unique:staffs',
            'no_telp' => 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $dosen->foto);
                if (file_exists($path)) {
                    unlink($path);
                }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotodosen',$namaFileBaru, 'public');

            $validatedData['foto']=$path;
           

        }
        else{
            if ($validatedData['nama'] != $dosen->nama) {
            
                $namaFotoLama = $dosen->foto;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['nama'] . '.' . $extension;
                
                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/fotodosen/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);
        

                $validatedData['foto'] = 'fotodosen/' . $namaFileBaru;
            }else{
                $cek=dosen::find($dosen->id);
                $validatedData['foto']=$cek->foto;
            }
        }

        $cekuser = User::where('email', $dosen->email)->first();

        if ($cekuser) {
            $cekuser->update(['email' => $validatedData['email']]);
        }

        $validatedData['jabatan'] = $dosen->jabatan;

        
        $editdata=$dosen->update($validatedData);
        if(!$editdata){
            return back()->with('Failed', 'Data gagal diupdate');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Mengubah data dosen dengan id = '.$dosen->id
        ]);  
        return redirect('admin/dosendetail/'. $dosen->id)->with('success', 'Data has been updated');
    }

    public function destroy($id)
{
    if (!Gate::allows('isAdmin')) {
        return redirect('/');
    } 
    $data = Dosen::findOrFail($id);
    
    $cekuser = User::where('email', $data->email)->first();
    if($cekuser){
        $cekuser->delete();
    }
    
    
    if ($data->foto != "-") {
        $path = storage_path('app/public/' . $data->foto);
        if (file_exists($path)) {
            unlink($path);
        }
    }
    $cek = prodi::where('ketuaprodi_id',$id)->first();
    if($cek){
        return redirect('admin/dosen')->with('Failed', 'Data tidak bisa dihapus karna dia merupakan '.$data->jabatan);
    }  
    $hapusdata=$data->delete();
        if(!$hapusdata){
            return redirect('admin/dosen')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menghapus data dosen dengan id = '.$id
        ]);  
    
    return redirect('admin/dosen')->with('success', 'Data has Been Deleted');
}

public function exportdosen(){
    if (!Gate::allows('isAdmin')) {
        return redirect('/');
    } 
    $data = dosen::all();
    return view('admin.pages.dosen.dosenekspor', ['data' => $data]);
}

}
