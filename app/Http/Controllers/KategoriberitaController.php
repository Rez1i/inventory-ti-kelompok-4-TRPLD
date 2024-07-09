<?php

namespace App\Http\Controllers;

use App\Models\berita;
use App\Models\kategori;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class KategoriberitaController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = kategori::all(); 
        return view('admin.pages.kategoriberita.kategoriberita', ['data' => $data]); 

    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin.pages.kategoriberita.kategoriberitacreate');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_kategori'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
        ]);
    
        $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
    
        $tambahdata=kategori::create($validatedData);
        if(!$tambahdata){
            return back()->with('Failed', 'Data gagal ditambahkan');
        }
        logaktivitas::create([
            'user_id'=>Auth::id(),
            'aktivitas' => 'Menambahkan data kategori berita dengan id = '.$tambahdata->id
        ]);   
        return redirect('admin/kategoriberita')->with('success', 'Data created successfully');
    }
    

    public function edit($id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $kategoriberita=kategori::find($id);
        return view('admin.pages.kategoriberita.kategoriberitaedit',['kategoriberita'=>$kategoriberita]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_kategori'=> 'required|max:255',
            'keterangan'=> 'required|max:255'
        ]);
        $validatedData['keterangan'] = strip_tags($validatedData['keterangan']);
        $editdata=kategori::where('id', $id)->update($validatedData);
        if(!$editdata){
            return back()->with('Failed', 'Data gagal diubah');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mengubah data kategori berita dengan id = '.$id
        ]);   
        return redirect('admin/kategoriberita')->with('success', 'Data has been update');       
    }
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = kategori::findOrFail($id);
        $berita = berita::where('kategori_id', $id)->first();
        if($berita){
            return redirect('admin/kategoriberita')->with('Failed', 'Berita dengan kategori '.$data->nama_kategori.' masih ada');
        }
        $hapusdata=$data->delete();
        if(!$hapusdata){
            return redirect('admin/kategoriberita')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menghapus data kategori berita dengan id = '.$id
        ]);   
        return redirect('admin/kategoriberita')->with('success', 'Data has Been Deleted');
    }
}
