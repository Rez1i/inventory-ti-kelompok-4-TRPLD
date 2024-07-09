<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\prodi;
use App\Models\mahasiswa;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = mahasiswa::all();
        return view('admin/pages/mahasiswa/mahasiswa', ['data' => $data]);

    }
    public function detail(mahasiswa $mahasiswa, $id){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $mahasiswa=mahasiswa::find($id);
        return view('admin/pages/mahasiswa/mahasiswadetail',['mahasiswa'=>$mahasiswa]);
    }
    public function downloadcontoh(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return response()->download(public_path('storage/contohfileimport/mahasiswaimport.xlsx'));
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
                'nim' => $rowData[2],
                'email' => $rowData[3],
                'prodi' => $rowData[4],
                'no_telp' => $rowData[5],
            ], [
                'nama'=> 'required|max:255',
                'nim'=> 'required|max:255|unique:mahasiswas',
                'email'=> 'required|email|max:255|unique:dosens|unique:mahasiswas|unique:staffs',
                'prodi'=> 'required|max:255',
                'no_telp' => 'required|max:15|unique:mahasiswas'
            ]);

            if ($validator->fails()) {
                continue;
            }

            $prodi = prodi::where('nama_prodi',$rowData[4])->first();
            if(!$prodi){
                continue;
            }

            $tambahdata= Mahasiswa::create([
                'nama' => $rowData[1],
                'nim' => $rowData[2],
                'email' => $rowData[3],
                'prodi_id' => $prodi->id,
                'no_telp' => $rowData[5]
            ]);

            if(!$tambahdata){
                continue;
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data mahasiswa baru dengan id'.$tambahdata->id
            ]);

            $successCount++;
        }

        if ($successCount > 0) {
            return redirect('admin/mahasiswa/import')->with('success', 'Data mahasiswa berhasil diimpor.');
        } else {
            return redirect('admin/mahasiswa/import')->with('Failed', 'Tidak ada data mahasiswa yang valid diimpor.')->withErrors($errorMessages);
        }
    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = prodi::all();
        return view('admin.pages.mahasiswa.mahasiswacreate',['data'=> $data]);
    }
    public function sinkrondata(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=mahasiswa&file=index');
        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['list'] as $index => $item) {
                $validator = Validator::make([
                    'nama' => $item['nama'],
                    'nim' => $item['nim'],
                    'prodi' => $item['prodi']
                ], [
                    'nama'=> 'required|max:255',
                    'nim'=> 'required|max:255|unique:mahasiswas',
                    'prodi'=> 'required|max:255'
                ]);

                if ($validator->fails()) {
                    continue;
                }

                $prodi = prodi::where('nama_prodi',$item['prodi'])->first();
                if(!$prodi){
                    continue;
                }

                $tambahdata= Mahasiswa::create([
                    'nama' => $item['nama'],
                    'nim' => $item['nim'],
                    'email' => '-',
                    'prodi_id' => $prodi->id,
                    'no_telp' => '-',
                    'foto' => '-'
                ]);

                if(!$tambahdata){
                    continue;
                }
                logaktivitas::create([
                    'user_id'=>Auth::id(),
                    'aktivitas' => 'Menambah data mahasiswa dengan id = '.$tambahdata->id
                ]);
            }
            return back()->with('success','Data Berhasil di Sinkronisasi');
        }else{
            return redirect('admin/dosen')->with('Failed', 'Data gagal di Sinkronisasi');
        }
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'nama'=> 'required|max:255',
            'nim'=> 'required|max:255|unique:mahasiswas',
            'email'=> 'required|max:255|unique:mahasiswas|unique:dosens|unique:staffs',
            'prodi_id'=> 'required|max:255',
            'no_telp'=> 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotomahasiswa',$namaFileBaru, 'public');

            $validatedData['foto']=$path;
        }
        else{
            $validatedData['foto']="-";
        }


        $tambahdata = Mahasiswa::create($validatedData);
            if(!$tambahdata){
                return redirect('admin/mahasiswa')->with('Failed', 'Data gagal ditambahkan');
            }
            logaktivitas::create([
                'user_id'=> Auth::id(),
                'aktivitas' => 'Menambahkan data mahasiswa baru dengan id = '.$tambahdata->id
            ]);
            return redirect('admin/mahasiswa')->with('success', 'Data created successfully');
    }

    public function edit(mahasiswa $mahasiswa)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = prodi::all();
        return view('admin.pages.mahasiswa.mahasiswaedit',['mahasiswa'=>$mahasiswa],['data'=> $data]);
    }
    public function update(Request $request, mahasiswa $mahasiswa)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:255|unique:mahasiswas,nim,' . $mahasiswa->id,
            'email' => 'required|max:255|unique:mahasiswas,email,' . $mahasiswa->id, '|unique:dosens|unique:staffs',
            'prodi_id' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $mahasiswa->foto);
                if (file_exists($path)) {
                    unlink($path);
                }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['nama'] . '.' . $extension;

            $path = $file->storeAs('fotomahasiswa',$namaFileBaru, 'public');

            $validatedData['foto']=$path;


        }
        else{
            if ($validatedData['nama'] != $mahasiswa->nama) {

                $namaFotoLama = $mahasiswa->foto;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['nama'] . '.' . $extension;

                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/fotomahasiswa/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);


                $validatedData['foto'] = 'fotomahasiswa/' . $namaFileBaru;
            }else{
                $cek=mahasiswa::find($mahasiswa->id);
                $validatedData['foto']=$cek->foto;
            }
        }

        $cekuser = User::where('email', $mahasiswa->email)->first();

        if ($cekuser) {
            $cekuser->update(['email' => $validatedData['email']]);
        }

        $ubahdata=$mahasiswa->update($validatedData);
        if(!$ubahdata){
            return redirect('admin/mahasiswa')->with('Failed', 'Data gagal diubah');
        }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mengubah data mahasiswa dengan id = '.$mahasiswa->id
        ]);
        return redirect('admin/mahasiswadetail/'.$mahasiswa->id)->with('success', 'Data has been updated');
    }

    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = mahasiswa::findOrFail($id);

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
        $hapusdata= $data->delete();
        if(!$hapusdata){
            return redirect('admin/mahasiswa')->with('Failed', 'Data gagal dihapus');
            }
        logaktivitas::create([
            'user_id'=> Auth::id(),
            'aktivitas' => 'Mengubah data mahasiswa dengan id = '.$id
        ]);
        return redirect('admin/mahasiswa')->with('success', 'Data has Been Deleted');
    }

    public function exportmahasiswa(){
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = mahasiswa::all();
        return view('admin.pages.mahasiswa.mahasiswaekspor', ['data' => $data]);
    }

}