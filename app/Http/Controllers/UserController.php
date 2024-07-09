<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\dosen;
use App\Models\staff;
use App\Models\berita;
use App\Models\masalah;
use App\Models\komentar;
use App\Models\mahasiswa;
use App\Models\transaksi;
use App\Models\notifikasi;
use App\Models\barangmasuk;
use App\Models\barangkeluar;
use App\Models\dbmasuk;
use App\Models\logaktivitas;
use App\Models\pengajuanpeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = User::wherenot('role', 'Administrator')->wherenot('id', Auth::id())->get();
        return view('admin.pages.user.user', ['data' => $data]);
    }
    public function create()
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
            return redirect('/');
        }

        return view('admin.pages.user.usercreate');
    }
    public function downloadcontoh()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        return response()->download(public_path('storage/contohfileimport/userimport.xlsx'));
    }
    public function process(Request $request)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
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
                'namalengkap' => $rowData[1],
                'username' => $rowData[2],
                'email' => $rowData[3],
                'password' => $rowData[4],
                'role' => $rowData[5]
            ], [
                'namalengkap' => 'required|max:255',
                'username' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|max:255',
                'role' => 'required|max:15'
            ]);

            if ($validator->fails()) {
                $errorMessages[] = "Baris " . $row->getRowIndex() . ": " . implode(", ", $validator->errors()->all());
                continue;
            }

            $rowData[4] = Hash::make($rowData[4]);

            $cekmahasiswa = mahasiswa::where('email', $rowData[3])->where('nama', $rowData[1])->first();
            $cekdosen = dosen::where('email', $rowData[3])->where('nama', $rowData[1])->first();
            $cekstaff = staff::where('email', $rowData[3])->where('nama', $rowData[1])->first();

            if ($cekmahasiswa) {
                $foto = $cekmahasiswa->foto;
            } elseif ($cekdosen) {
                $foto = $cekdosen->foto;
            } elseif ($cekstaff) {
                $foto = $cekstaff->foto;
            } else {
                continue;
            }

            if (!in_array($rowData[5], ["Admin", "User", "Pimpinan"])) {
                continue;
            }


            $tambahdata = user::create([
                'username' => $rowData[2],
                'email' => $rowData[3],
                'password' => $rowData[4],
                'role' => $rowData[5],
                'profile_photo' => $foto
            ]);

            if (!$tambahdata) {
                continue;
            }
            if (Gate::allows('isAdmin')) {
                logaktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Menambahkan data user dengan id = ' . $tambahdata->id
                ]);
            }

            $successCount++;
        }

        if ($successCount > 0) {
            return redirect('admin/user/import')->with('success', 'Data Dosen berhasil diimpor.');
        } else {
            return redirect('admin/user/import')->with('Failed', 'Tidak ada data Dosen yang valid diimpor.')->withErrors($errorMessages);
        }
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        $user = user::all()->count();
        if ($user > 1) {
            $validatedData = $request->validate([
                'namalengkap' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|max:255|unique:users',
                'password' => 'required|min:8|max:255|confirmed',
                'role' => 'required'
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $cekmahasiswa = mahasiswa::where('email', $validatedData['email'])->orwhere('nama', $validatedData['namalengkap'])->first();
            $cekdosen = dosen::where('email', $validatedData['email'])->orwhere('nama', $validatedData['namalengkap'])->first();
            $cekstaff = staff::where('email', $validatedData['email'])->orwhere('nama', $validatedData['namalengkap'])->first();

            if ($cekmahasiswa) {
                $validatedData['profile_photo'] = $cekmahasiswa->foto;
            } elseif ($cekdosen) {
                $validatedData['profile_photo'] = $cekdosen->foto;
                if (strpos($cekdosen->jabatan, "Ketua") !== false) {
                    $validatedData['role'] = "Pimpinan";
                }
            } elseif ($cekstaff) {
                $validatedData['profile_photo'] = $cekstaff->foto;
            } else {
                return back()->with('Failed', 'Data tidak tercatat di database.');
            }

            $tambahdata = user::create($validatedData);
            if (!$tambahdata) {
                return back()->with('Failed', 'Data Gagal DItambahkan.');
            }

            if (Gate::allows('isAdmin')) {
                logaktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Menambahkan data user dengan id = ' . $tambahdata->id
                ]);
                return redirect('admin/user')->with('success', 'Data Berhasil Ditambahkan.');
            }

            if (Gate::allows('isAdministrator')) {
                return redirect('/administrator')->with('success', 'Data Berhasil Ditambahkan.');
            }
        } else {
            $validatedData = $request->validate([
                'username' => 'required|max:255|unique:users',
                'email' => 'required|max:255|unique:users',
                'password' => 'required|min:8|max:255|confirmed',
                'role' => 'required'
            ]);
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['email_verified_at'] = Carbon::now()->tz('Asia/Jakarta');
            user::create($validatedData);
            return redirect('/administrator')->with('success', 'Data Berhasil Ditambahkan.');
        }
    }


    public function edit(user $user)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        return view('admin.pages.user.useredit', ['user' => $user]);
    }
    public function update(Request $request, user $user)
    {
        if (!Gate::allows('isAdmin') || Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        if (!$request->password) {
            $validatedData['password'] = $user->password;
            $validatedData = $request->validate([
                'username' => 'required|max:255',
                'email' => 'required|max:255|unique:users,email,' . $user->id . '|email:dns',
                'role' => 'required'
            ]);
        } else {
            $validatedData = $request->validate([
                'username' => 'required|max:255',
                'email' => 'required|max:255|unique:users,email,' . $user->id . '|email:dns',
                'password' => 'required|min:8|max:255|',
                'role' => 'required'
            ]);
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $cekemailold = user::find($user->id);
        $cekmahasiswa = mahasiswa::where('email', $cekemailold->email)->first();
        $cekdosen = dosen::where('email', $cekemailold->email)->first();
        $cekstaff = staff::where('email', $cekemailold->email)->first();

        if ($cekmahasiswa) {
            Mahasiswa::where('email', $cekmahasiswa->email)->update(['email' => $validatedData['email']]);
        } elseif ($cekdosen) {
            dosen::where('email', $cekdosen->email)->update(['email' => $validatedData['email']]);
        } elseif ($cekstaff) {
            staff::where('email', $cekstaff->email)->update(['email' => $validatedData['email']]);
        } else {
            return back()->with('Failed', 'Data tidak tercatat di database.');
        }

        $editdata = user::where('id', $user->id)->update($validatedData);
        if (!$editdata) {
            return back()->with('Failed', 'Data gagal diubah.');
        }
        if (Gate::allows('isAdmin')) {
            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Mengubah data user dengan id = ' . $user->id
            ]);
        }
        return redirect('admin/userdetail/' . $user->id)->with('success', 'Data berhasil di Update');
    }

    public function destroy($id)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        $data = user::findOrFail($id);
        barangkeluar::where('user_id', $id)->delete();
        //barangmasuk::where('user_id', $id)->delete();
        $barangmasuk = barangmasuk::where('user_id', $id)->first();
        dbmasuk::where('barangmasuk_id', $barangmasuk->id)->delete();
        $barangmasuk->delete();
        komentar::where('user_id', $id)->delete();
        berita::where('user_id', $id)->delete();
        transaksi::where('user_id', $id)->delete();
        notifikasi::where('user_id', $id)->delete();
        logaktivitas::where('user_id', $id)->delete();
        masalah::where('user_id', $id)->delete();
        pengajuanpeminjaman::where('user_id', $id)->delete();
        $hapusdata = $data->delete();
        if (!$hapusdata) {
            return redirect('admin/user')->with('Failed', 'Data gagal dihapus');
        }
        if (Gate::allows('isAdmin')) {
            logaktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Menghapus data user dengan id = ' . $id
            ]);
            return redirect('admin/user')->with('success', 'Data has Been Deleted');
        }

        return redirect('/administrator')->with('success', 'Data has Been Deleted');
    }

    public function detail($id)
    {
        if (!Gate::allows('isAdmin') && !Gate::allows('isAdministrator')) {
            return redirect('/');
        }
        $user = user::find($id);
        $cekmahasiswa = mahasiswa::where('email', $user->email)->first();
        $cekdosen = dosen::where('email', $user->email)->first();
        $cekstaff = staff::where('email', $user->email)->first();

        if ($cekmahasiswa) {
            $data = $cekmahasiswa;
        } elseif ($cekdosen) {
            $data = $cekdosen;
        } elseif ($cekstaff) {
            $data = $cekstaff;
        } else {
            return back()->with('Failed', 'Data tidak tercatat di database.');
        }

        return view('admin.pages.user.userdetail', ['user' => $user], ['data' => $data]);
    }

    public function exportuser()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        }
        $data = User::all();
        return view('admin.pages.user.userekspor', ['data' => $data]);
    }
}
