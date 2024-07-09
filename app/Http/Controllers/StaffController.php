<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\staff;
use App\Models\bagian;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = staff::all();
        return view('admin/pages/staff/staff', ['data' => $data]); 

    }
    public function detail(staff $staff, $id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $staff=staff::find($id);
        return view('admin/pages/staff/staffdetail',['staff'=>$staff]);

    }
    public function downloadcontoh(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return response()->download(public_path('storage/contohfileimport/staffimport.xlsx'));
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
                'nik' => $rowData[2],
                'email' => $rowData[3],
                'bagiankerja' => $rowData[4],
                'no_telp' => $rowData[5],
            ], [
                'nama'=> 'required|max:255',
                'nik'=> 'required|max:255|unique:staffs',
                'email'=> 'required|email|max:255|unique:dosens|unique:mahasiswas|unique:staffs',
                'bagiankerja'=> 'required|max:255',
                'no_telp' => 'required|max:15|unique:staffs'
            ]);

            if ($validator->fails()) {
                continue;
            }

            $bagian = bagian::where('nama_bagian',$rowData[4])->first();
            if(!$bagian){
                continue;
            }
            
            $tambahdata= staff::create([
                'nama' => $rowData[1],
                'nik' => $rowData[2],
                'email' => $rowData[3],
                'bagian_id' => $bagian->id,
                'no_telp' => $rowData[5]
            ]);
            
            if(!$tambahdata){
                continue;
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data staff baru dengan id = '.$tambahdata->id
            ]);  

            
            $successCount++;
        }

        if ($successCount > 0) {
            return redirect('admin/staff/import')->with('success', 'Data staff berhasil diimpor.');
        } else {
            return redirect('admin/staff/import')->with('Failed', 'Tidak ada data staff yang valid diimpor.')->withErrors($errorMessages);
        }
    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = bagian::all();
        return view('admin.pages.staff.staffcreate', ['data'=>$data]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama'=> 'required|max:255',
            'nik'=> 'required|max:255|unique:staffs',
            'email'=> 'required|max:255|unique:staffs|unique:mahasiswas|unique:dosens',
            'no_telp'=> 'required|max:255',
            'bagian_id'=> 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotostaff',$namaFileBaru, 'public');

            $validatedData['foto']=$path;
        }
        else{
            $validatedData['foto']="-";
        }
    
        $tambahdata= staff::create($validatedData);
        if(!$tambahdata){
            return redirect('admin/staff')->with('Failed', 'Data gagal ditambahkan');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menambahkan data staff baru dengan id = '.$tambahdata->id
        ]);  
        
        return redirect('admin/staff')->with('success', 'Data created successfully');
    }

    public function edit(staff $staff)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = bagian::all();
        return view('admin.pages.staff.staffedit',['staff'=>$staff], ['data'=>$data]);
    }
    public function update(Request $request, staff $staff)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nik' => 'required|max:255|unique:staffs,nik,' . $staff->id,
            'email' => 'required|max:255|unique:staffs,email,' . $staff->id,'|unique:mahasiswas|unique:dosens',
            'no_telp' => 'required|max:255',
            'bagian_id'=> 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);

        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $staff->foto);
                if (file_exists($path)) {
                    unlink($path);
                }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotostaff',$namaFileBaru, 'public');

            $validatedData['foto']=$path;
           

        }
        else{
            if ($validatedData['nama'] != $staff->nama) {
            
                $namaFotoLama = $staff->foto;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['nama'] . '.' . $extension;
                
                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/fotostaff/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);
        

                $validatedData['foto'] = 'fotostaff/' . $namaFileBaru;
            }else{
                $cek=staff::find($staff->id);
                $validatedData['foto']=$cek->foto;
            }
        }

        $cekuser = User::where('email', $staff->email)->first();

        if ($cekuser) {
            $cekuser->update(['email' => $validatedData['email']]);
        }
    
        $editdata=$staff->update($validatedData);
        if(!$editdata){
            return redirect('admin/staffdetail/'.$staff->id)->with('Failed', 'Data gagal diubah');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mengubah data staff yang mempunyai id = '.$staff->id
        ]);  
        
        return redirect('admin/staffdetail/'.$staff->id)->with('success', 'Data has been updated');
    }

    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = staff::findOrFail($id);

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

       
        $hapusdata = $data->delete();
        if(!$hapusdata){
            return redirect('admin/staff')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mmenghapus data staff dengan id = '.$id
        ]);  
        return redirect('admin/staff')->with('success', 'Data has Been Deleted');
    }

    public function exportstaff(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = staff::all();
        return view('admin.pages.staff.staffekspor', ['data' => $data]);
    }
}
