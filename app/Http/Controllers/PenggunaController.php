<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\dosen;
use App\Models\staff;
use App\Models\barang;
use App\Models\berita;
use App\Models\baranghp;
use App\Models\kategori;
use App\Models\mahasiswa;
use App\Models\transaksi;
use App\Models\notifikasi;
use App\Models\jenisbarang;
use Illuminate\Support\Str;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use App\Models\kategoribarang;
use Illuminate\Support\Carbon;
use App\Models\pengajuanpeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function barang()
    {
        $barang = Barang::paginate(10);
        $baranghp = BarangHp::paginate(10);
        $jenisbarang = JenisBarang::all();
        $kategoribarang = KategoriBarang::all();

        return view('user.pages.barang.barangtersediadilabor', [
            'semuabarang' => $barang,
            'semuabaranghp' => $baranghp,
            'jenisbarang' => $jenisbarang,
            'kategoribarang' => $kategoribarang,
            'jenisbarangselect' => '-',
            'kategoribarangselect' => '-',
            'sifatbarangselect' => '-',
            'waktu' => '-'

        ]);
    }



    public function barangfilter(Request $request)
    {
        $query = Barang::query();

        if ($request->has('sifatbarang') && $request->sifatbarang != '-') {
            $query->where('sifatbarang', $request->sifatbarang);
        }

        if ($request->has('jenisbarang_id') && $request->jenisbarang_id != '-') {
            $query->where('jenisbarang_id', $request->jenisbarang_id);
        }

        if ($request->has('kategoribarang_id') && $request->kategoribarang_id != '-') {
            $query->whereHas('jenis_barang', function ($query) use ($request) {
                $query->where('kategoribarang_id', $request->kategoribarang_id);
            });
        }

        if ($request->has('waktu') && $request->waktu != '-') {
            $query->orderBy('created_at', $request->waktu);
        } else {
            $query->orderBy('created_at', 'asc');
        }

        // Paginate $semuabarang with 8 items per page
        $semuabarang = $query->paginate(10);

        // Filter and paginate $baranghp only if no filter by sifatbarang or jenisbarang_id
        $baranghp = collect(); // Default to an empty collection

        if (
            !$request->has('sifatbarang') || $request->sifatbarang == '-' &&
            (!$request->has('jenisbarang_id') || $request->jenisbarang_id == '-')
        ) {

            $queryBarangHp = BarangHp::query();

            if ($request->has('kategoribarang_id') && $request->kategoribarang_id != '-') {
                $queryBarangHp->where('kategoribarang_id', $request->kategoribarang_id);
            }

            if ($request->has('waktu') && $request->waktu != '-') {
                $queryBarangHp->orderBy('created_at', $request->waktu);
            } else {
                $queryBarangHp->orderBy('created_at', 'asc');
            }

            // Paginate $baranghp with 8 items per page
            $baranghp = $queryBarangHp->paginate(10);
        }

        // Load other necessary data
        $jenisbarang = JenisBarang::all();
        $kategoribarang = KategoriBarang::all();

        return view('user.pages.barang.barangtersediadilabor', [
            'semuabarang' => $semuabarang,
            'semuabaranghp' => $baranghp,
            'jenisbarang' => $jenisbarang,
            'kategoribarang' => $kategoribarang,
            'jenisbarangselect' => $request->jenisbarang_id ?? '-',
            'kategoribarangselect' => $request->kategoribarang_id ?? '-',
            'sifatbarangselect' => $request->sifatbarang ?? '-',
            'waktu' => $request->waktu ?? '-'
        ]);
    }

    public function beritaFilter(Request $request)
    {
        $query = Berita::query();
        $beritaterbaru = Berita::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Menghapus tag HTML, mengganti &nbsp; dengan spasi biasa, dan membatasi 100 karakter
                $item->isi_berita = Str::limit(str_replace('&nbsp;', ' ', strip_tags($item->isi_berita)), 100);
                return $item;
            });

        // Filter by kategori_id
        if ($request->has('kategori_id') && $request->kategori_id != '-') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by waktu (ascending or descending)
        if ($request->has('waktu') && $request->waktu != '-') {
            $query->orderBy('created_at', $request->waktu);
        } else {
            $query->orderBy('created_at', 'asc');
        }

        // Paginate results with 8 items per page
        $beritalainnya = $query->whereNotIn('id', $beritaterbaru->pluck('id'))->paginate(10);
        // Load other necessary data
        $kategori = Kategori::all();

        return view('user.pages.berita.berita', [
            'beritalainnya' => $beritalainnya,
            'kategori' => $kategori,
            'kategoriselect' => $request->kategori_id ?? '-',
            'waktu' => $request->waktu ?? '-',
            'beritaterbaru' => $beritaterbaru
        ]);
    }



















    public function pengajuanpeminjaman($id)
    {
        $barang = barang::find($id);
        if ($barang->status == 'Sedang Dipinjam' || $barang->sifatbarang == 'Tidak Boleh Dipinjam') {
            return back()->with('Failed', 'Mohon maaf, anda tidak bisa meminjam barang ini');
        }
        $tambahdata = pengajuanpeminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $barang->id,
            'status' => 'Sedang Diajukan'
        ]);
        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, sistem gagal mencatat pengajuan');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengajukan Peminjaman Barang dengan id = ' . $tambahdata->id
        ]);
        return back()->with('success', 'Terima kasih, Kami akan memberikan kabar jika pengajuan anda diterima.');
    }

    public function datapengajuanpeminjaman()
    {
        $data = pengajuanpeminjaman::where('user_id', Auth::id())->get();
        return view('/user/pages/barang/datapengajuan', ['data' => $data]);
    }

    public function pengajuanbatal($id)
    {
        $data = pengajuanpeminjaman::findorfail($id);
        if (!$data) {
            return back()->with('Failed', 'Mohon maaf, ada kesalahan.');
        }
        $data->delete();
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Membatalkan pengajuan Peminjaman Barang dengan id = ' . $id
        ]);
        return back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function riwayat()
    {
        $data = transaksi::where('peminjam', Auth::user()->email)->where('status', 'Selesai')->orwhere('status', 'Selesai Terlambat')->get();
        return view('/user/pages/barang/riwayatpeminjaman', ['data' => $data]);
    }

    public function sedangdipinjam()
    {
        $data = transaksi::where('peminjam', Auth::user()->email)->where('status', 'Sedang Dipinjam')->get();

        $sekarang = Carbon::now();
        $dataSedangDipinjam = [];
        foreach ($data as $item) {
            $item->masapinjam = $sekarang->diffInDays($item->bataswaktu);
            $dataSedangDipinjam[] = $item;
        }
        return view('/user/pages/barang/sedangdipinjam', ['data' => $dataSedangDipinjam]);
    }

    public function notifikasi()
    {
        $data = notifikasi::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        return view('/admin/pages/pengguna/notifikasi', ['data' => $data]);
    }

    public function sarankomentar(request $request)
    {
        $validatedData = $request->validate([
            'komentar' => 'required'
        ]);
        $validatedData['komentar'] = strip_tags($validatedData['komentar']);

        $data = transaksi::find($request->id);
        if (!$data) {
            return back()->with('Failed', 'Mohon maaf, ada kesalan dari sistem.');
        }
        $tambahdata = $data->update(['sarankomentar' => $validatedData['komentar']]);
        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, ada kesalan dari sistem.');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Memberikan Saran dan komentar pada data transaksi dengan id = ' . $request->id
        ]);
        return redirect('/riwayatpeminjaman')->with('success', 'Terima kasih karena telah memberikan Saran dan komentar anda.');
    }

    public function ubahusername(request $request)
    {
        $validatedData = $request->validate([
            'usernamebaru' => 'required|max:225'
        ]);
        $data = User::find(Auth::id());
        if (!$data) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, ada kesalahan pada sistem.');
        }
        $datauser = mahasiswa::where('email', Auth::user()->email)->first();
        if (!$datauser) {
            $datauser = dosen::where('email', Auth::user()->email)->first();
            if (!$datauser) {
                $datauser = staff::where('email', Auth::user()->email)->first();
            }
        }
        $validatedData['profile_photo'] = $data->profile_photo;
        if ($datauser->foto != $data->profile_photo) {
            $namaFotoLama = $data->profile_photo;
            $extension = pathinfo($namaFotoLama, PATHINFO_EXTENSION);
            $namaFileBaru = $validatedData['usernamebaru'] . '.' . $extension;

            $pathFotoLama = storage_path('app/public/' . $namaFotoLama);
            $pathFotoBaru = storage_path('app/public/fotouser/' . $namaFileBaru);
            rename($pathFotoLama, $pathFotoBaru);

            $validatedData['profile_photo'] = 'fotouser/' . $namaFileBaru;
        }


        $ubahdata = $data->update([
            'username' => $validatedData['usernamebaru'],
            'profile_photo' => $validatedData['profile_photo']
        ]);

        if (!$ubahdata) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, ada kesalahan pada sistem.');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengganti username user dengan id = ' . $data->id
        ]);
        return redirect('/editprofile')->with('success', 'Username anda sudah berhasil diperbarui.');
    }

    public function ubahemail(request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:users'
        ]);
        $user = user::find(Auth::id());
        $data = mahasiswa::where('email', Auth::user()->email)->first();
        if (!$data) {
            $data = dosen::where('email', Auth::user()->email)->first();
            if (!$data) {
                $data = staff::where('email', Auth::user()->email)->first();
            }
        }
        $ubahuser = $user->update(['email' => $validatedData['email'],'email_verified_at'=> null]);
        $ubahdata = $data->update(['email' => $validatedData['email']]);

        if (!$ubahdata || !$ubahuser) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, ada kesalahan pada sistem.');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengganti email user dengan id = ' . $user->id
        ]);

        return redirect('/editprofile')->with('success', 'Email anda sudah berhasil diperbarui.');
    }

    public function ubahpassword(request $request)
    {
        $validatedData = $request->validate([
            'passwordlama' => 'required',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = user::find(Auth::id());
        if (!$user) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, ada kesalahan pada sistem');
        }
        if (!Hash::check($validatedData['passwordlama'], $user->password)) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, Anda gagal memperbarui password');
        }

        $ubahdata = $user->update(['password' => $validatedData['password']]);
        if (!$ubahdata) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, ada kesalahan pada sistem');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengganti password user dengan id = ' . $user->id
        ]);

        return redirect('/editprofile')->with('success', 'Password anda sudah berhasil diperbarui.');
    }
    public function ubahfoto(request $request)
    {
        $validatedData = $request->validate([
            'foto' => 'required|mimes:jpeg,png,jpg|max:2048'

        ]);
        $user = user::find(auth::id());
        $cek = dosen::where('email',$user->email)->first();
        $pathcek = 'fotodosen';
        if(!$cek){
            $cek = mahasiswa::where('email',$user->email)->first();
            $pathcek = 'fotomahasiswa';
            if(!$cek){
                $cek = staff::where('email',$user->email)->first();
                $pathcek = 'fotostaff';
            }
        }

        if ($request->file('foto')) {
            $path = storage_path('app/public/' . $user->profile_photo);
            if (file_exists($path)) {
                unlink($path);
            }
            $path = storage_path('app/public/' . $cek->foto);
            if (file_exists($path)) {
                unlink($path);
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $user->username . '.' . $extension;

            $path = $file->storeAs('fotouser', $namaFileBaru, 'public');
            $pathcek = $file->storeAs($pathcek, $namaFileBaru, 'public');

            $validatedData['foto'] = $path;
            $cek->update(['foto'=>$pathcek]);
        } else {
            $validatedData['foto'] = $user->profile_photo;
        }
        $ubahdata = $user->update(['profile_photo' => $validatedData['foto']]);
        if (!$ubahdata) {
            return redirect('/editprofile')->with('Failed', 'Mohon maaf, Foto anda gagal diunggah');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengganti foto user dengan id = ' . $user->id
        ]);
        return redirect('/editprofile')->with('success', 'Foto profil anda berhasil diunggah.');
    }

    public function berita()
    {
        $beritaterbaru = Berita::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Menghapus tag HTML, mengganti &nbsp; dengan spasi biasa, dan membatasi 100 karakter
                $item->isi_berita = Str::limit(str_replace('&nbsp;', ' ', strip_tags($item->isi_berita)), 100);
                return $item;
            });



        $beritalainnya = berita::whereNotIn('id', $beritaterbaru->pluck('id'))->orderBy('created_at', 'desc')->simplePaginate(5);
        $kategori = Kategori::all();
        $kategoriselect = 0;
        $waktu = '-';
        return view('/user/pages/berita/berita', ['beritaterbaru' => $beritaterbaru], [
            'beritalainnya' => $beritalainnya,
            'kategori' => $kategori,
            'kategoriselect' => $kategoriselect,
            'waktu' => $waktu
        ]);
    }

    public function carimenu(Request $request)
    {
        $data = [
            'Mahasiswa',
            'Dosen',
            'Staff',
            'User',
            'Berita',
            'Program Studi',
            'Bagian Kerja',
            'Ruangan',
            'Penempatan',
            'Pemindahan Inventaris',
            'Jenis Barang',
            'Satuan Barang',
            'Barang Yang boleh dipinjam',
            'Barang Tetap',
            'Barang Habis Pakai',
            'Kategori Barang',
            'Kategori Berita',
            'Barang Masuk',
            'Barang Keluar',
            'Peminjaman / Pengembalian',
            'Mutasi Barang',
            'Dosen Import',
            'User Import',
            'Mahasiswa Import',
            'Staff Import',
            'Ruangan Import',
            'Penempatan Barang',
            'User Export',
            'Dosen Export',
            'Mahasiswa Export',
            'Staff Export',
            'Barang',
            'Barang Habis Pakai',
            'Barang Keluar',
            'Peminjaman dan Pengembalian'
        ];

        $link = [
            '/admin/mahasiswa',
            '/admin/dosen',
            '/admin/staff',
            '/admin/user',
            '/admin/berita',
            '/admin/prodi',
            '/admin/bagian',
            '/admin/ruangan',
            '/admin/penempatan',
            '/admin/pemindahaninventaris',
            '/admin/jenisbarang',
            '/admin/satuan',
            '/admin/barangpinjam',
            '/admin/barang',
            '/admin/baranghp',
            '/admin/kategoribarang',
            '/admin/kategoriberita',
            '/admin/barangmasuk',
            '/admin/barangkeluar',
            '/admin/transaksi',
            '/admin/mutasibarang',
            '/admin/dosen/import',
            '/admin/user/import',
            '/admin/mahasiswa/import',
            '/admin/staff/import',
            '/admin/ruangan/import',
            '/admin/penempatan/import',
            '/admin/eksporuser',
            '/admin/ekspordosen',
            '/admin/ekspormahasiswa',
            '/admin/eksporstaff',
            '/admin/eksporbarang',
            '/admin/eksporbaranghp',
            '/admin/eksporbarangkeluar',
            '/admin/eksportransaksi'
        ];

        $searchInput = $request->input('search-input');

        foreach ($data as $index => $menu) {
            if (strpos(strtolower($menu), strtolower($searchInput)) !== false) {
                return redirect($link[$index]);
            }
        }

        // Redirect to a default page or show an error message if no match is found
        return redirect('/');
    }
}