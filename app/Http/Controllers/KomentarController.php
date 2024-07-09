<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\dosen;
use App\Models\staff;
use App\Models\komentar;
use App\Models\mahasiswa;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
   public function index(){
      
   }
   public function store(request $request){
      $validatedData = $request->validate([
         'berita_id'=> 'required|max:255',
         'isi_komentar'=> 'required'
     ]);

     $validatedData['user_id'] = auth::id();

     $tambahdata=komentar::create($validatedData);

     if($tambahdata){
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menambahkan komentar id = '.$tambahdata->id.'di berita dengan id'.$validatedData['berita_id']
        ]);   
         return back()->with('Success','Komentar berhasil dikirim');
     }
     else{
         return back()->with('Failed','Komentar gagal dikirim');
     }
    
   }
   public function destroy($id)
   {
       $data = komentar::findOrFail($id);
    if (!Gate::allows('isAdmin')) {
        if($data->user_id != Auth::id()){
            return redirect('/');
        }
        
    } 
    
       $hapusdata = $data->delete();
       if(!$hapusdata){
        return back()->with('Failed', 'Komentar gagal dikirim');
       }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menghapus komentar id = '.$id.'di berita dengan id'.$data->berita_id
        ]);   
       return back()->with('success', 'Data has Been Deleted');
   }
}
