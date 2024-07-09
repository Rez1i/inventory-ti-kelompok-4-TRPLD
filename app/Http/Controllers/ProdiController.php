<?php

namespace App\Http\Controllers;
use App\Models\user;
use App\Models\dosen;
use App\Models\prodi;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = prodi::all(); 
        return view('admin/pages/prodi/prodi',['data' =>$data]); 

    }
    public function detail($id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $prodi=prodi::find($id);
        $ketua=dosen::where('id',$prodi->ketuaprodi_id);
        return view('admin.pages.prodi.prodidetail',['prodi'=>$prodi],['ketua' => $ketua]);
    }

    public function sinkrondata()
{
    if (!Gate::allows('isAdmin')) {
        return redirect('/');
    } 
    $prodi = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=prodi');
    $kaprodi = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=kaprodi');
    
    if ($prodi->successful() && $kaprodi->successful()) {
        $dataprodi = $prodi->json();
        $datakaprodi = $kaprodi->json();
        
        foreach ($dataprodi['list'] as $index => $item) {
            $ketua_prodi = null;
            
            foreach ($datakaprodi['list'] as $kaprodi_item) {
                if ($kaprodi_item['kode_prodi'] == $item['kode_prodi']) {
                    $ketua_prodi = $kaprodi_item['nama'];
                    break;
                }
            }
            
            if (!$ketua_prodi) {
                continue; // Skip jika tidak ada ketua prodi yang cocok
            }
            
            $validator = Validator::make([
                'nama_prodi' => $item['prodi'],
                'jenjangstudi' => $item['id_jenjang'],
                'namakaprodi' => $ketua_prodi
            ], [
                'nama_prodi' => 'required|max:255|unique:prodis,nama_prodi',
                'jenjangstudi' => 'required|max:255',
                'namakaprodi' => 'required|max:255'
            ]);
    
            if ($validator->fails()) {
                continue;
            }
            
            $cek = Dosen::where('nama', $ketua_prodi)->first();
            
            if (!$cek) {
                continue; // Skip jika dosen tidak ditemukan
            }
    
            $tambahdata = Prodi::create([
                'nama_prodi' => $item['prodi'],
                'singkatan' => '-',
                'jenjangstudi' => $item['id_jenjang'],
                'akreditasi' => '-',
                'ketuaprodi_id' => $cek->id,
                'tahunberdiri' => '-'
            ]);
    
            if (!$tambahdata) {
                continue;
            }
    
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menambah data prodi dengan id = ' . $tambahdata->id
            ]); 
            
            $prodi_baru = Prodi::where('ketuaprodi_id', $cek->id)->first();
            $cek->update(['jabatan' => 'Ketua Jurusan Program Studi ' . $prodi_baru->nama_prodi]);
        }
        
        return back()->with('success', 'Data berhasil disinkronisasi');
    } else {
        return back()->with('error', 'Gagal mendapatkan data dari server');
    }
}


    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        return view('admin.pages.prodi.prodicreate');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $validatedData = $request->validate([
            'nama_prodi'=> 'required|max:255|unique:prodis,nama_prodi',
            'singkatan'=> 'required|max:255|unique:prodis,singkatan',
            'jenjangstudi'=> 'required|max:255',
            'akreditasi'=> 'required|max:255',
            'nama'=> 'required|max:255',
            'tahunberdiri'=> 'required|max:255'
        ]);

        $cek=dosen::where('nama',$validatedData['nama'])->first();
        if(!$cek){
            return redirect('admin/prodi')->with('failed', 'Nama Ketua tidak terdaftar di sistem');
        }
        $validatedData['ketuaprodi_id'] = $cek->id;
        $tambahdata = Prodi::create($validatedData);
        if(!$tambahdata){
            return redirect('admin/prodi')->with('failed', 'Data gagal ditambahkan');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menambahkan data program studi dengan id'.$tambahdata->id
        ]);   
        $prodi = prodi::where('ketuaprodi_id',$validatedData['ketuaprodi_id'])->first();
        $cek->update(['jabatan'=>'Ketua Jurusan Program Studi '.$prodi->nama_prodi]);
        return redirect('admin/prodi')->with('success', 'Data created successfully');
    }
    

    public function edit(prodi $prodi)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $cek=dosen::find($prodi->ketuaprodi_id);
        $prodi->nama = $cek->nama;
        return view('admin.pages.prodi.prodiedit',['prodi'=>$prodi]);
    }
    public function update(Request $request, prodi $prodi)
    {
        $validatedData = $request->validate([
            'nama_prodi'=> 'required|max:255|unique:prodis,nama_prodi,' . $prodi->id,
            'singkatan'=> 'required|max:255|unique:prodis,singkatan,'. $prodi->id,
            'jenjangstudi'=> 'required|max:255',
            'akreditasi'=> 'required|max:255',
            'nama'=> 'required|max:255',
            'tahunberdiri'=> 'required|max:255'
        ]);

        $cek=dosen::where('nama',$validatedData['nama'])->first();
        if(!$cek){
            return redirect('admin/prodi')->with('failed', 'Nama tidak terdaftar di sistem');
        }
        if($cek->id != $prodi->ketuaprodi_id){
            $kaprodilama=dosen::find($prodi->ketuaprodi_id);
            $kaprodilama->update(['jabatan'=>'Dosen']);
            user::where('email',$kaprodilama->email)->update(['role'=>'User']);
        }
        
        $validatedData['ketuaprodi_id']=$cek->id;

        $editdata = prodi::find($prodi->id)->update($validatedData);
        if(!$editdata){
            return redirect('admin/prodi')->with('failed', 'Data gagal di Update');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mengubah data program studi dengan id'.$prodi->id
        ]);   
        $prodi = prodi::where('ketuaprodi_id',$validatedData['ketuaprodi_id'])->first();
        $cek->update(['jabatan'=>'Ketua Jurusan Program Studi '.$prodi->nama_prodi]);
        user::where('email',$cek->email)->update(['role' => 'Pimpinan']);
        return redirect('admin/prodi')->with('success', 'Data has been update');
            
    }
        
    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = prodi::findOrFail($id);
        $dosen = dosen::find($data->ketuaprodi_id);
        $hapus=$data->delete();
        if(!$hapus){
            return redirect('admin/prodi')->with('failed', 'Data has Not Been Deleted');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Menghapus data program studi dengan id'.$id
        ]);   
        $dosen->update(['jabatan'=>'Dosen']);
        user::where('email',$dosen->email)->update(['role'=>'User']);
        return redirect('admin/prodi')->with('success', 'Data has Been Deleted');
    }
}
