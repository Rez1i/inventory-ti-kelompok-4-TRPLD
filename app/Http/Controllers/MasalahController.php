<?php

namespace App\Http\Controllers;

use App\Models\masalah;
use App\Models\notifikasi;
use App\Models\logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MasalahController extends Controller
{
    public function create()
    {
        if (Gate::allows('isAdmin')) {
            return view('/admin/pages/pengguna/lapormasalah');
        }elseif(Gate::allows('isPimpinan')){
            return view('/admin/pages/pengguna/lapormasalah');
        }elseif(Gate::allows('isUser')){
            return view('/user/pages/profil/lapormasalah');
        }

    }

    public function store(request $request)
    {
        $validatedData = $request->validate([
            'laporan' => 'required'
        ]);

        $validatedData['laporan'] = strip_tags($validatedData['laporan']);

        $tambahdata = masalah::create([
            'user_id' => Auth::id(),
            'laporandanmasukan' => $validatedData['laporan'],
            'tanggapan' => '-'
        ]);
        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, ada kesalahan dari sistem.');
        }
        logaktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Memberikan masukan dan komentar dengan id = ' . $tambahdata->id
        ]);
        return back()->with('success', 'Terima kasih, masukan dan komentar anda berhasil terkirim.');
    }

    public function edit($id)
    {
        $masalah = masalah::find($id);
        return view('admin/pages/pengguna/tanggapanmasalah', ['masalah' => $masalah]);
    }

    public function update(request $request, $id)
    {
        $request->tanggapan = strip_tags($request->tanggapan);
        $tambahtanggapan = masalah::where('id', $id)->update(['tanggapan' => $request->tanggapan]);
        if (!$tambahtanggapan) {
            return back()->with('Failed', 'Gagal menanggapi saran atau komentar.');
        }
        notifikasi::create([
            'user_id' => $request->user_id,
            'judul' => 'Pemberitahuan',
            'notifikasi' => 'Laporan saran dan masukan anda telah di tanggapi oleh admin. Pesan, ' . $request->sarandanmasukan . 'Tanggapan, ' . $request->tanggapan
        ]);
        return redirect('/administrator')->with('success', 'Tanggapan berhasil dikirimkan');
    }
}