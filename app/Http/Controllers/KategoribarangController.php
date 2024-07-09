<?php

namespace App\Http\Controllers;

use App\Models\baranghp;
use App\Models\jenisbarang;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\kategoribarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class KategoribarangController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = kategoribarang::all(); 
        return view('admin/pages/kategoribarang/kategoribarang', ['data' => $data]); 

    }
    
    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin.pages.kategoribarang.kategoribarangcreate');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_kategoribarang'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
        ]);
    
        $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
    
        $tambahdata=kategoribarang::create($validatedData);
        if(!$tambahdata){
            return redirect('admin/kategoribarang')->with('Failed', 'Data gagal ditambahkan');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menambahkan data kategori barang dengan id = '.$tambahdata->id
        ]);    
        return redirect('admin/kategoribarang')->with('success', 'Data created successfully');
    }
    public function edit(kategoribarang $kategoribarang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin.pages.kategoribarang.kategoribarangedit',['kategoribarang'=>$kategoribarang]);
    }

    public function update(Request $request, kategoribarang $kategoribarang)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_kategoribarang'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
        ]);

        $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
        $editdata=kategoribarang::where('id', $kategoribarang->id)->update($validatedData);
        if(!$editdata){
            return redirect('admin/kategoribarang')->with('Failed', 'Data gagal diupdate');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Mengubah data kategori barang dengan id = '.$kategoribarang->id
        ]);    
        return redirect('admin/kategoribarang')->with('success', 'Data has been update');
            
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = kategoribarang::findOrFail($id);
        $jenisbarang = jenisbarang::where('kategoribarang_id',$id)->first();
        $baranghp = baranghp::where('kategoribarang_id',$id)->first();
        if($jenisbarang || $baranghp){
            return redirect('admin/kategoribarang')->with('Failed', 'Terdapat beberapa barang yang masih berkategori '. $data->nama_kategoribarang);
        }
        $hapusdata=$data->delete();
        if(!$hapusdata){
            return redirect('admin/kategoribarang')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menghapus data kategori barang dengan id = '.$id
        ]);   
        return redirect('admin/kategoribarang')->with('success', 'Data has Been Deleted');
    }
}
