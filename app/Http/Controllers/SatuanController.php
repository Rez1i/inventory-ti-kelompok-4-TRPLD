<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\satuan;
use App\Models\dbmasuk;
use App\Models\baranghp;
use App\Models\barangkeluar;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SatuanController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = satuan::all(); 
        return view('admin/pages/satuan/satuan',['data' =>$data]); 

    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin.pages.satuan.satuancreate');
    }

    public function store(Request $request)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $validatedData = $request->validate([
                'nama_satuan'=> 'required|max:255',
                'keterangan'=> 'required|max:255'
            ]);
        
            $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
        
            $tambahdata= satuan::create($validatedData);
            if(!$tambahdata){
                return redirect('admin/satuan')->with('Failed', 'Data gagal ditambahakan');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data satuan dengan id = '.$tambahdata->id
            ]);   
            return redirect('admin/satuan')->with('success', 'Data created successfully');
        }

    public function edit(satuan $satuan)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            return view('admin.pages.satuan.satuanedit',['satuan'=>$satuan]);
        }

    public function update(Request $request, satuan $satuan)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $validatedData = $request->validate([
                'nama_satuan'=> 'required|max:255',
                'keterangan'=> 'required|max:255'
            ]);

            $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
                $editdata= satuan::where('id', $satuan->id)->update($validatedData);
                if(!$editdata){
                    return redirect('admin/satuan')->with('Failed', 'Data gagal diubah');
                }
                logaktivitas::create([
                    'user_id'=> Auth::id(),
                    'aktivitas' => 'Mengubah data satuan dengan id = '.$satuan->id
                ]);  
                return redirect('admin/satuan')->with('success', 'Data has been update');
                
        }
    public function destroy($id)
        {
            if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
            $data = satuan::findOrFail($id);
            $barang=barang::where('satuan_id',$id)->first();
            $baranghp=baranghp::where('satuan_id',$id)->first();
            $barangkeluar=barangkeluar::where('satuan_id',$id)->first();
            $dbmasuk=dbmasuk::where('satuan_id',$id)->first();
            if($barang || $baranghp || $barangkeluar || $dbmasuk){
                return redirect('admin/satuan')->with('Failed', 'Masih ada data barang yang menggunakan satuan ini');
            }

            $hapusdata=$data->delete();
            if(!$hapusdata){
                return redirect('admin/satuan')->with('Failed', 'Data gagal dihapus');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menghapus data satuan dengan id = '.$id
            ]);  
            return redirect('admin/satuan')->with('success', 'Data has Been Deleted');
        }
}
