<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\jenisbarang;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\kategoribarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JenisbarangController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = jenisbarang::all();
        $barang = barang::all();
        foreach ($data as $item) {
            $jumlahbarang = $barang->where('jenisbarang_id',$item->id)->count();
            $item->update(['jumlahbarang' => $jumlahbarang]);
        }
        $data = jenisbarang::all();
        return view('admin/pages/jenisbarang/jenisbarang', ['data' => $data]); 

    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data=kategoribarang::all();
        return view('admin.pages.jenisbarang.jenisbarangcreate',['data'=> $data]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_jenisbarang'=> 'required|max:255',
            'kategoribarang_id'=> 'required|max:255'
        ]);

        $tambahdata=jenisbarang::create($validatedData);
        if(!$tambahdata){
            return redirect('admin/jenisbarang')->with('Failed', 'Data gagal ditambahakan');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menambahkan data jenis barang dengan id = '.$tambahdata->id
        ]);          
        return redirect('admin/jenisbarang')->with('success', 'Data created successfully');
    }

    public function edit(jenisbarang $jenisbarang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data=kategoribarang::all();
        return view('admin.pages.jenisbarang.jenisbarangedit',['jenisbarang'=>$jenisbarang],['data'=>$data]);
    }
    public function update(Request $request, jenisbarang $jenisbarang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_jenisbarang'=> 'required|max:255',
            'kategoribarang_id'=> 'required|max:255'
        ]);

    
        $editdata=jenisbarang::where('id', $jenisbarang->id)->update($validatedData);
        if(!$editdata){
            return redirect('admin/jenisbarang')->with('Failed', 'Data gagal diupdate');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Mengubah data jenis barang dengan id = '.$jenisbarang->id
        ]);    
        return redirect('admin/jenisbarang')->with('success', 'Data has been update');
            
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = jenisbarang::findOrFail($id);
        $databarang = barang::where('jenisbarang_id',$id)->first();
        if($databarang){
            return redirect('admin/jenisbarang')->with('Failed', 'Masih ada data yang jenis barangnya '.$data->nama_jenisbarang);
        }
        $hapusdata= $data->delete();
        if(!$hapusdata){
            return redirect('admin/jenisbarang')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menghapus data jenis barang dengan id = '.$id
        ]);    
        return redirect('admin/jenisbarang')->with('success', 'Data has Been Deleted');
    }
}
