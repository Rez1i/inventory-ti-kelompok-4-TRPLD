<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MasalahController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BaranghpController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\JenisbarangController;
use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\MutasibarangController;
use App\Http\Controllers\KategoribarangController;
use App\Http\Controllers\KategoriberitaController;
use App\Http\Controllers\PemindahaninventarisController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [DashboardController::class, 'index']);

Route::middleware('hak_akses')->group(function () {

    Route::get('/admin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/adminpimpinan', [DashboardController::class, 'dashboardpimpinan']);
    Route::get('/adminuser', [DashboardController::class, 'dashboarduser']);
    Route::get('/administrator', [DashboardController::class, 'dashboardadministrator']);

    //Route Program Studi
    Route::get('/admin/sinkronprodi', [ProdiController::class, 'sinkrondata']);
    Route::get('/admin/prodi/prodidetail/{id}', [ProdiController::class, 'detail']);
    Route::resource('/admin/prodi', ProdiController::class);

    Route::resource('/admin/satuan', SatuanController::class);
    //Route::resource('/admin/jabatan', JabatanController::class);
    Route::resource('/admin/bagian', BagianController::class);
    Route::resource('/admin/jenisbarang', JenisbarangController::class);
    Route::resource('/admin/kategoribarang', KategoribarangController::class);
    Route::resource('/admin/kategoriberita', KategoriberitaController::class);
    Route::resource('/admin/pemindahaninventaris', PemindahaninventarisController::class);

    Route::get('/barang', [PenggunaController::class, 'barang']);
    Route::match(['get', 'post'], '/barangfilter', [PenggunaController::class, 'barangfilter']);
    Route::match(['get', 'post'], '/baranghpfilter', [PenggunaController::class, 'baranghpfilter']);

    Route::get('/restore', [BackupController::class, 'restore']);
    Route::get('/backup', [BackupController::class, 'backup']);

    //Route Barang

    Route::get('/admin/barangrusak', [BarangController::class, 'barangrusak']);
    Route::post('/admin/barangrusak/{id}', [BarangController::class, 'barangrusakhapus']);
    Route::post('/admin/tambahbarangrusak', [BarangController::class, 'tambahbarangrusak']);

    Route::get('/admin/eksporbarang', [BarangController::class, 'exportbarang']);
    Route::get('/admin/barangpinjam', [BarangController::class, 'barangpinjam']);
    Route::post('/admin/barangpinjam/{id}', [BarangController::class, 'barangpinjamhapus']);
    Route::post('/admin/tambahbarangpinjam', [BarangController::class, 'tambahbarangpinjam']);
    Route::resource('/admin/barang', BarangController::class);
    Route::get('/admin/barangdetail/{id}', [BarangController::class, 'detail']);


    //Route Barang Habis Pakai
    Route::get('/admin/eksporbaranghp', [BaranghpController::class, 'exportbaranghp']);
    Route::resource('/admin/baranghp', BaranghpController::class);
    Route::get('/admin/baranghpdetail/{id}', [BaranghpController::class, 'detail']);


    //Barang Masuk
    Route::get('/admin/tambahbarangimport/{id}', function ($id) {
        return view('admin.pages.barangmasuk.importbarangmasuk', ['id' => $id]);
    });

    Route::get('/admin/inputbarangmasuk/downloadlaporan/{id}', [barangmasukController::class, 'downloadlaporan']);
    Route::post('/admin/barangmasuk/import', [barangmasukController::class, 'process']);
    Route::get('/admin/contohfilebarangmasuk', [barangmasukController::class, 'downloadcontoh']);
    Route::get('/admin/tambahbarang', [BarangmasukController::class, 'tambahbarang']);
    Route::get('/admin/tambahbarangmasuk/{id}', [BarangmasukController::class, 'barangmasuk']);
    Route::get('/admin/tambahbaranghpmasuk/{id}', [BarangmasukController::class, 'baranghpmasuk']);
    Route::get('/admin/inputbarangmasuk/{id}', [BarangmasukController::class, 'inputbarang']);
    Route::post('/admin/baranghapus/{kodebarang}', [BarangmasukController::class, 'hapusbarang']);
    Route::resource('/admin/barangmasuk', BarangmasukController::class);


    //Barang Keluar
    Route::get('/admin/eksporbarangkeluar', [BarangkeluarController::class, 'exportbarangkeluar']);
    Route::resource('/admin/barangkeluar', BarangkeluarController::class);
    Route::get('/admin/barangkeluardetail/{id}', [BarangkeluarController::class, 'detail']);


    Route::get('/notifikasi', [PenggunaController::class, 'notifikasi']);
    Route::get('/berita', [PenggunaController::class, 'berita']);
    Route::match(['get', 'post'], '/beritafilter', [PenggunaController::class, 'beritafilter']);
    Route::get('/editprofile', function () {
        if (Auth::user()->role != 'User') {
            return view('admin.pages.pengguna.editprofile');
        } elseif (Auth::user()->role = 'User') {
            return view('user.pages.profil.editprofile');
        }
    });
    Route::get('/ubahusername', function () {
        if (Auth::user()->role != 'User') {
            return view('admin.pages.pengguna.ubahusername');
        } elseif (Auth::user()->role = 'User') {
            return view('user.pages.profil.ubahusername');
        }
    });
    Route::post('/ubahusername', [PenggunaController::class, 'ubahusername']);

    Route::get('/ubahemail', function () {
        if (Auth::user()->role != 'User') {
            return view('admin.pages.pengguna.ubahemail');
        } elseif (Auth::user()->role = 'User') {
            return view('user.pages.profil.ubahemail');
        }
    });
    Route::post('/ubahemail', [PenggunaController::class, 'ubahemail']);

    Route::post('/carimenu', [PenggunaController::class, 'carimenu']);

    Route::get('/ubahpassword', function () {
        if (Auth::user()->role != 'User') {
            return view('admin.pages.pengguna.ubahpassword');
        } elseif (Auth::user()->role = 'User') {
            return view('user.pages.profil.ubahpassword');
        }
    });
    Route::post('/ubahpassword', [PenggunaController::class, 'ubahpassword']);

    Route::get('/ubahfotoprofile', function () {
        if (Auth::user()->role != 'User') {
            return view('admin.pages.pengguna.ubahfoto');
        } elseif (Auth::user()->role = 'User') {
            return view('user.pages.profil.ubahfoto');
        }
    });
    Route::post('/ubahfoto', [PenggunaController::class, 'ubahfoto']);

    Route::resource('/laporkanmasalah', MasalahController::class);

    // routes/web.php

    Route::get('/data-peminjaman-perbulan', 'DashboardController@getDataPeminjamanPerBulan');



    //Route Transaksi
    Route::get('/sarankomentar/{id}', function ($id) {
        return view('admin.pages.pengguna.sarankomentar', ['id' => $id]);
    });
    Route::get('/admin/barangsedangdipinjam', [TransaksiController::class, 'sedangdipinjam']);
    Route::post('/sarankomentar', [PenggunaController::class, 'sarankomentar']);
    Route::get('/transaksipeminjaman/{id}', [TransaksiController::class, 'peminjamandengandata']);
    Route::get('/riwayatpeminjaman', [PenggunaController::class, 'riwayat']);
    Route::get('/sedangdipinjam', [PenggunaController::class, 'sedangdipinjam']);
    Route::get('/tolakpengajuan/{id}', [TransaksiController::class, 'tolakpengajuan']);
    Route::get('/terimapengajuan/{id}', [TransaksiController::class, 'terimapengajuan']);
    Route::get('/pengajuanbatal/{id}', [PenggunaController::class, 'pengajuanbatal']);
    Route::get('/pengajuanpeminjaman', [PenggunaController::class, 'datapengajuanpeminjaman']);
    Route::get('/admin/pengajuan', [TransaksiController::class, 'datapengajuanpeminjaman']);
    Route::post('/pengajuanpeminjaman/{id}', [PenggunaController::class, 'pengajuanpeminjaman']);
    Route::get('/admin/eksportransaksi', [TransaksiController::class, 'exporttransaksi']);
    Route::resource('/admin/transaksi', TransaksiController::class);
    Route::get('/admin/transaksipeminjaman', [TransaksiController::class, 'peminjaman']);
    Route::get('/admin/transaksipengembalian', [TransaksiController::class, 'pengembalian']);


    //Route Mutasi Barang

    Route::get('/admin/contohfilemutasi', [MutasibarangController::class, 'downloadcontoh']);
    Route::get('/admin/mutasibarang/import/{mutasi_id}', function ($mutasi_id) {
        return view('admin.pages.mutasibarang.databarangmutasiimport', ['mutasi_id' => $mutasi_id]);
    });

    Route::post('/admin/mutasibarang/import', [MutasibarangController::class, 'process']);
    Route::get('/admin/downloadlaporanmutasi/{id}', [MutasibarangController::class, 'downloadlaporan']);
    Route::resource('/admin/mutasibarang', MutasibarangController::class);
    Route::get('/admin/barangmutasi/{id}', [MutasibarangController::class, 'databarang']);


    //Route Berita
    Route::get('/admin/beritadetail/{id}', [BeritaController::class, 'detail']);
    Route::resource('/admin/berita', BeritaController::class);

    Route::get('/barang/print', [BarangController::class, 'print'])->name('print_barcode');
    Route::get('/baranghp/print', [BaranghpController::class, 'print'])->name('print_barcodehp');



    //Route Komentar
    Route::resource('/admin/komentarberita', KomentarController::class);

    //Route Penempatan
    Route::get('/admin/penempatan/import', function () {
        return view('admin.pages.penempatan.penempatanimport');
    });
    Route::post('/admin/penempatan/import', [penempatanController::class, 'process']);
    Route::get('/admin/contohfilepenempatan', [penempatanController::class, 'downloadcontoh']);
    Route::resource('/admin/penempatan', PenempatanController::class);

    //Route Ruangan
    Route::get('/admin/ruangan/import', function () {
        return view('admin.pages.ruangan.ruanganimport');
    });
    Route::post('/admin/ruangan/import', [RuanganController::class, 'process']);
    Route::get('/admin/contohfileruangan', [RuanganController::class, 'downloadcontoh']);
    Route::resource('/admin/ruangan', RuanganController::class);


    //Route Mahasiswa
    Route::get('/admin/sinkronmahasiswa', [MahasiswaController::class, 'sinkrondata']);
    Route::get('/admin/ekspormahasiswa', [MahasiswaController::class, 'exportmahasiswa']);
    Route::get('/admin/mahasiswa/import', function () {
        return view('admin.pages.mahasiswa.mahasiswaimport');
    });
    Route::get('/admin/mahasiswadetail/{id}', [MahasiswaController::class, 'detail']);
    Route::post('/admin/mahasiswa/import', [MahasiswaController::class, 'process']);
    Route::get('/admin/contohfilemahasiswa', [MahasiswaController::class, 'downloadcontoh']);
    Route::resource('/admin/mahasiswa', MahasiswaController::class);


    //Route Dosen
    Route::get('/admin/sinkrondosen', [DosenController::class, 'sinkrondata']);
    Route::get('/admin/dosen/import', function () {
        return view('admin.pages.dosen.dosenimport');
    });
    Route::post('/admin/dosen/import', [DosenController::class, 'process'])->name('dosen.import');
    Route::get('/admin/contohfiledosen', [DosenController::class, 'downloadcontoh']);
    Route::get('/admin/ekspordosen', [DosenController::class, 'exportdosen']);
    Route::get('/admin/dosen/export', [DosenController::class, 'export'])->name('dosen.export');
    Route::get('/admin/dosendetail/{id}', [DosenController::class, 'detail']);
    Route::resource('/admin/dosen', DosenController::class);


    //Route Staff
    Route::get('/admin/eksporstaff', [StaffController::class, 'exportstaff']);
    Route::get('/admin/staff/import', function () {
        return view('admin.pages.staff.staffimport');
    });
    Route::post('/admin/staff/import', [StaffController::class, 'process']);
    Route::get('/admin/contohfilestaff', [StaffController::class, 'downloadcontoh']);
    Route::get('/admin/staffdetail/{id}', [StaffController::class, 'detail']);
    Route::resource('/admin/staff', StaffController::class);


    //Route User
    Route::get('/admin/user/import', function () {
        return view('admin.pages.user.userimport');
    });
    Route::get('/admin/userdetail/{id}', [UserController::class, 'detail']);
    Route::get('/admin/eksporuser', [UserController::class, 'exportuser']);
    Route::post('/admin/user/import', [UserController::class, 'process']);
    Route::get('/admin/contohfileuser', [UserController::class, 'downloadcontoh']);
    Route::resource('/admin/user', UserController::class);
});





//==========================================================================================
Route::get('/login', [LoginController::class, 'indexlogin'])->middleware('guest')->name('login');;
Route::post('/login', [LoginController::class, 'storelogin']);


Route::get('/register', [LoginController::class, 'indexregister'])->middleware('guest');
Route::get('/registermahasiswa', [LoginController::class, 'indexregistermahasiswa'])->middleware('guest');
Route::get('/registerdosen', [LoginController::class, 'indexregisterdosen'])->middleware('guest');
Route::get('/registerstaff', [LoginController::class, 'indexregisterstaff'])->middleware('guest');
Route::post('/registermahasiswa', [LoginController::class, 'storeregistermahasiswa'])->middleware('guest');
Route::post('/registerdosen', [LoginController::class, 'storeregisterdosen'])->middleware('guest');
Route::post('/registerstaff', [LoginController::class, 'storeregisterstaff'])->middleware('guest');


Route::get('/forget', [LoginController::class, 'inputpassword'])->middleware('guest');
Route::post('/forget', [LoginController::class, 'Sendemail'])->middleware('guest');

Route::get('/check', [LoginController::class, 'check'])->middleware('guest');

Route::get('/validation/{token}', [LoginController::class, 'validationemail'])->middleware('guest')->name('validation');;
Route::post('/validation', [LoginController::class, 'resetpassword'])->middleware('guest');




Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/logout', [LoginController::class, 'logout']);
