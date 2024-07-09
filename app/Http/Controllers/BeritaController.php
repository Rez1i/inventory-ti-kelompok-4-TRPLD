<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\user;
use App\Models\berita;
use App\Models\kategori;
use App\Models\komentar;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BeritaController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = berita::all();
        return view('admin/pages/berita/berita', ['data' => $data]);
    }

    public function detail($id)
    {
        if (Auth::user()->role != 'User') {
            $komentar = Komentar::where('berita_id', $id)->paginate(5);
            $berita = berita::find($id);
            return view('admin.pages.berita.beritadetail', ['berita' => $berita], ['komentar' => $komentar]);
        } elseif (Auth::user()->role = 'User') {
            $komentar = Komentar::where('berita_id', $id)->paginate(5);
            $berita = berita::find($id);
            return view('user.pages.berita.beritadetail', ['berita' => $berita], ['komentar' => $komentar]);
        }
    }

    public function create()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = kategori::all();
        return view('admin.pages.berita.beritacreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'kategori_id' => 'required|max:255',
            'isi_berita' => 'required',
            'gambar' => 'required|mimes:jpeg,png,jpg|max:2048'

        ]);
        $validatedData['user_id'] = Auth::id();
        $datetime = Carbon::now();
        $validatedData['published'] = $datetime->format('Y-m-d H:i:s');


        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['judul'] . '.' . $extension;

            $path = $file->storeAs('gambarberita', $namaFileBaru, 'public');

            $validatedData['gambar'] = $path;
        } else {
            $validatedData['gambar'] = "-";
        }

        $tambah = berita::create($validatedData);
        if (!$tambah) {
            return redirect('admin/berita')->with('Failed', 'Data gagal dibuat');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menambahkan berita baru dengan id = ' . $tambah->id
        ]);

        return redirect('admin/berita')->with('success', 'Data created successfully');
    }
    public function edit($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $berita = berita::find($id);
        $data = kategori::all();
        return view('admin.pages.berita.beritaedit', ['berita' => $berita, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'kategori_id' => 'required|max:255',
            'isi_berita' => 'required',
            'gambar' => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        $berita = berita::find($id);

        $validatedData['user_id'] = Auth::id();
        $datetime = Carbon::now();
        $validatedData['published'] = $datetime->format('Y-m-d H:i:s');


        if ($request->file('gambar')) {
            $path = storage_path('app/public/' . $berita->gambar);
            if (file_exists($path)) {
                unlink($path);
            }

            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $validatedData['judul'] . '.' . $extension;

            $path = $file->storeAs('gambarberita', $namaFileBaru, 'public');

            $validatedData['gambar'] = $path;
        } else {
            if ($validatedData['judul'] != $berita->judul) {

                $namaFotoLama = $berita->gambar;
                $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
                $namaFileBaru = $validatedData['judul'] . '.' . $extension;

                $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
                $pathFotoBaru = storage_path('app/public/gambarberita/' . $namaFileBaru);
                rename($pathFotoLama, $pathFotoBaru);
                $validatedData['gambar'] = 'gambarberita/' . $namaFileBaru;
            } else {
                $cek = berita::find($berita->id);
                $validatedData['gambar'] = $cek->gambar;
            }
        }

        $editberita = berita::where('id', $id)
            ->update($validatedData);
        if (!$editberita) {
            return redirect('admin/berita')->with('Failed', 'Data gagal diubah');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Mengubah data berita dengan id = ' . $berita->id
        ]);
        return redirect('admin/berita')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = berita::findOrFail($id);
        if ($data->gambar != "-") {
            $path = storage_path('app/public/' . $data->gambar);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $komentar = komentar::where('berita_id', $id);
        $komentar->delete();
        $hapusberita = $data->delete();
        if (!$hapusberita) {
            return redirect('admin/berita')->with('Failed', 'Data gagal dihapus');
        }
        logaktivitas::create([
            'user_id' => auth::id(),
            'aktivitas' => 'Menghapus data berita dengan id = ' . $id
        ]);
        return redirect('admin/berita')->with('success', 'Data has Been Deleted');
    }
}
