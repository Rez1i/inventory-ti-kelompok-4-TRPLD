<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\dosen;
use App\Models\prodi;
use App\Models\staff;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\mahasiswa;
use App\Models\transaksi;
use App\Models\notifikasi;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    // Menampilkan
    public function indexlogin(){
        return view('auth.login');
    }
    
    public function indexregister(){
        return view('auth.register');
    }

    public function indexregistermahasiswa(){
        $data = prodi::all();
        return view('auth.registermahasiswa', ['data' => $data]);
    }

    public function indexregisterdosen(){
        return view('auth.registerdosen');
    }

    public function indexregisterstaff(){
        $data = bagian::all();
        return view('auth.registerstaff', ['data' => $data]);
    }
  
    public function storelogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user) {
                $role = Auth::user()->role;
                
                $role = Auth::user()->role;
                
                if ($role == "Admin" || $role == "Pimpinan" || $role == "User") {
                    $cek = transaksi::where('peminjam', Auth::user()->email)
                                    ->where('status', 'Sedang Dipinjam')
                                    ->first();
                
                    if ($cek) {
                        $batasWaktu =$cek->bataswaktu;
                        $sekarang = Carbon::now()->tz('Asia/Jakarta');
                
                        // Hitung selisih waktu dalam jam
                        $selisihJam = $sekarang->diffInHours($batasWaktu, false); // false untuk mendapatkan selisih tanpa desimal
                
                        $pesan = '';
                
                        // Pengecekan berdasarkan selisih waktu
                        if ($selisihJam < 24 && $selisihJam >= 12) {
                            $pesan = 'kurang dari 24 jam';
                        } elseif ($selisihJam < 12 && $selisihJam >= 6) {
                            $pesan = 'kurang dari 12 jam';
                        } elseif ($selisihJam < 6 && $selisihJam >= 3) {
                            $pesan = 'kurang dari 6 jam';
                        } elseif ($selisihJam < 3 && $selisihJam >= 1) {
                            $pesan = 'kurang dari 3 jam';
                        } elseif ($selisihJam < 1) {
                            $pesan = 'kurang dari 1 jam';
                        }
                
                        // Pengecekan jika sudah melewati batas waktu
                        if ($sekarang->gte($batasWaktu)) {
                            $pesan = 'sudah melewati batas waktu, segera hubungi pihak yang bertanggung jawab untuk mengembalikan barang!!';
                        }
                
                        // Jika ada pesan yang perlu dikirimkan, buat notifikasi
                        if (!empty($pesan)) {
                            // Periksa apakah notifikasi dengan pesan yang sama sudah pernah dikirim sebelumnya
                            $notifikasiTerakhir = Notifikasi::where('user_id', Auth::id())
                                                            ->where('notifikasi', 'like', '%' . $pesan . '%')
                                                            ->orderBy('created_at', 'desc')
                                                            ->first();
                
                            if (!$notifikasiTerakhir) {
                                $this->buatNotifikasi('Peringatan',Auth::id(), 'Batas waktu pengembalian peminjaman anda ' . $pesan);
                            }
                        }
                    }
                
                    // Redirect berdasarkan role pengguna
                    switch ($role) {
                        case 'Admin':
                            return redirect('/admin');
                        case 'Pimpinan':
                            return redirect('/adminpimpinan');
                        case 'User':
                            return redirect('/adminuser');
                    }
                }elseif($role == "Administrator") {
                    return redirect('/administrator');
                }
                
            } else {
                return back()->with('Failed','Login Failed');
            }
        }

        return back()->with('Failed', 'Login Failed');
    }

    public function buatNotifikasi($judul, $userId, $pesan) {
        // Buat entri notifikasi baru
        Notifikasi::create([
            'judul' => $judul,
            'user_id' => $userId,
            'notifikasi' => $pesan
        ]);
    }


    public function storeregistermahasiswa(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:255',
            'prodi_id' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'email' => 'required|max:255|email:dns|unique:users',
            'password'=> 'required|min:8|max:255|confirmed'
        ]);

    
        
        $cek = mahasiswa::where('nim',$validatedData['nim'])->orwhere('nama',$validatedData['nama'])->first();
        if($cek){
            $mahasiswa=$cek->update([
                'prodi_id' => $validatedData['prodi_id'],
                'no_telp' => $validatedData['no_telp'],
                'email' => $validatedData['email']
            ]);

            $validatedData['username'] = $validatedData['nama'];
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['role']="User";
            $user= User::create($validatedData);
            event(new Registered($user));
            $user = Auth::user();
    
            return redirect('/email/verify');
        }
        else{
            return back()->with('Failed','Data anda belum terdaftar di database kami, silahkan hubungi admin');

        }
    }
    public function storeregisterdosen(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'email' => 'required|max:255|email:dns|unique:users',
            'password'=> 'required|min:8|max:255|confirmed'
        ]);
        
        $cek = dosen::where('nip',$validatedData['nip'])->orwhere('nama',$validatedData['nama'])->first();
        if($cek){
            $dosen=$cek->update([
                'no_telp' => $validatedData['no_telp'],
                'email' => $validatedData['email']
            ]);

            $validatedData['username'] = $validatedData['nama'];
            $validatedData['password'] = Hash::make($validatedData['password']);
            if (strpos($cek->jabatan, "Ketua") !== false) {
                $validatedData['role'] = "Pimpinan";
            } else {
                $validatedData['role'] = "User";
            }
            
            $user= User::create($validatedData);
            event(new Registered($user));
            $user = Auth::user();
    
            return redirect('/email/verify');
        }
        else{
            return back()->with('Failed','Data anda belum terdaftar di database kami, silahkan hubungi admin');

        }
    }
    public function storeregisterstaff(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nik' => 'required|max:255',
            'bagian_id' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'email' => 'required|max:255|email:dns|unique:users',
            'password'=> 'required|min:8|max:255|confirmed'
        ]);
        
        $cek = staff::where('nik',$validatedData['nik'])->orwhere('nama',$validatedData['nama'])->first();
        if($cek){
            $staff=$cek->update([
                'bagian_id' => $validatedData['bagian_id'],
                'no_telp' => $validatedData['no_telp'],
                'email' => $validatedData['email']
            ]);

            $validatedData['username'] = $validatedData['nama'];
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['role']="User";
            $user= User::create($validatedData);
            event(new Registered($user));
            $user = Auth::user();
    
            return redirect('/email/verify');
        }
        else{
            return back()->with('Failed','Data anda belum terdaftar di database kami, silahkan hubungi admin');

        }
    }

    public function inputpassword(){
        return view('auth.forget');
    }

    public function Sendemail(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = \Str::random(60);

        PasswordResetToken::updateorcreate(
            [
                'email' =>$validatedData['email']
            ],
            [
                'email' => $validatedData['email'],
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::to($validatedData['email'])->send(new ResetPasswordMail($token));
        
        return redirect('/check')->with('success', 'Password reset has been sent');
    }

    public function check(){
        return view('auth.check');
    }
    public function validationemail(Request $request, $token){

        $getToken=PasswordResetToken::where('token', $token)->first();

        if (!$getToken) {
            return redirect('/login')->with('Failed','Your token is invalid');
        }
        
        return view('auth.resetpassword', compact('token'));
    }

    public function resetpassword(Request $request){
        $validatedData = $request->validate([
            'password' => 'required|min:8|max:255|confirmed'
        ]);
        
        $token=PasswordResetToken::where('token', $request->token)->first();
    
        if (!$token) {
            return redirect('/login')->with('Failed','Your token is invalid');
        }
    
        $user = User::where('email', $token->email)->first();
    
        if (!$user) {
            return redirect('/login')->with('Failed','Your account is not registered');
        }
    
        $data = $user->update([
            
            'password' => Hash::make($request->password)
        ]);
    
        if ($data) {
            $token->delete();
            return redirect('/login')->with('success','Your password has been changed');
        }
    
        return redirect('/login')->with('Failed','Your password has not changed');    
    }
    
    
    
    

    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }
}
