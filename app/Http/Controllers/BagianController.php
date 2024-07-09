<?php

namespace App\Http\Controllers;

use App\Models\staff;
use App\Models\bagian;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BagianController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = bagian::all(); 
        return view('admin/pages/bagian/bagian', ['data' => $data]); 

    }

    public function create()
    {
    if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
        return view('admin.pages.bagian.bagiancreate');
    }

    public function store(Request $request)
    {
    if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
        $validatedData = $request->validate([
            'nama_bagian'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
        ]);
    
        $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
    
        $tambahdata=bagian::create($validatedData);
        if(!$tambahdata){
            return redirect('admin/bagian')->with('Failed', 'Data Gagal ditambahakan');
        }
        logaktivitas::create([
            'user_id'=>auth::id(),
            'aktivitas' => 'Menambahkan data bagian dengan id = '.$tambahdata->id,
        ]);
        
        return redirect('admin/bagian')->with('success', 'Data created successfully');
    }
    

    public function edit(bagian $bagian)
    {
    if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
        return view('admin.pages.bagian.bagianedit',['bagian'=>$bagian]);
    }
    public function update(Request $request, bagian $bagian)
    {
    if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
        $validatedData = $request->validate([
            'nama_bagian'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
            

        ]);
        $ubahdata = bagian::where('id', $bagian->id)->update($validatedData);

        if(!$ubahdata){
            return redirect('admin/bagian')->with('Failed', 'Data gagal diupdate');
        }
        logaktivitas::create([
            'user_id'=>auth::id(),
            'aktivitas' => 'Mengubah data bagian kerja dengan id = '.$bagian->id,
        ]);
        
        return redirect('admin/bagian')->with('success', 'Data has been update');
            
    }
        
    public function destroy($id)
    {
    if (!Gate::allows('isAdmin')) {
                return redirect('/');
            } 
        $data = bagian::findOrFail($id);
        $cek=staff::where('bagian_id',$data->id)->first();
        if($cek){
            return redirect('admin/bagian')->with('Failed', 'Data staff dengan bagian '.$data->nama_bagian.' masih ada');
        }
        $hapusdata = $data->delete();
        if(!$hapusdata){
            return redirect('admin/bagian')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=>auth::id(),
            'aktivitas' => 'Menghapus data bagian kerja dengan id = '.$data->id,
        ]);

        return redirect('admin/bagian')->with('success', 'Data has Been Deleted');
    }
}
