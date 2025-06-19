<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyhomeController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\DataSantriController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\InfaqController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilekController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// Halaman utama (landing page)
Route::get('/', [HomeController::class, 'index']); // Halaman publik sebelum login

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware('auth')->group(function () {
    Route::get('/dashboard/bendahara', [MyhomeController::class, 'index'])->name('bendahara');
    Route::get('/dashboard/ketua', [AdminController::class, 'ketua'])->name('ketua');

    // Halaman utama setelah login (opsional)
    Route::get('/home', [HomeController::class, 'home']);

    // Kelola Kas
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::post('/kas/kredit', [KasController::class, 'storeKredit'])->name('kas.kredit');
    Route::post('/kas/debit', [KasController::class, 'storeDebit'])->name('kas.debit');
    Route::get('/kas/edit/{id}', [KasController::class, 'edit'])->name('kas.edit');
    Route::put('/kas/update/{id}', [KasController::class, 'update'])->name('kas.update');
    Route::delete('/kas/delete/{id}', [KasController::class, 'destroy'])->name('kas.destroy');
    Route::get('/laporan-kas', [KasController::class, 'laporan'])->name('kas.laporan');
    Route::get('/laporan-kas/cetak', [KasController::class, 'cetak'])->name('kas.laporan.cetak');
    //Route::get('/laporan-kas', [KasController::class, 'laporanKas'])->name('laporan.kas');
    Route::get('/laporan-kas/export', [KasController::class, 'export'])->name('kas.export');

    // Kelola Tabungan
    Route::get('/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');
    Route::post('/tabungan/setoran', [TabunganController::class, 'setoran'])->name('tabungan.setoran');
    Route::post('/tabungan/penarikan', [TabunganController::class, 'penarikan'])->name('tabungan.penarikan');
    Route::get('/tabungan/detail/{id}', [TabunganController::class, 'detail'])->name('tabungan.detail');
    Route::put('/tabungan/edit/{id}', [TabunganController::class, 'edit'])->name('tabungan.edit');
    Route::delete('/tabungan/hapus/{id}', [TabunganController::class, 'hapus'])->name('tabungan.hapus');
    Route::get('/tabungan/transaksi/{id}', [TabunganController::class, 'getTransaksi']);
    Route::get('/tabungan/cetak/{id}', [TabunganController::class, 'cetak']);
        Route::get('/tabungan/gambar/{id}', [TabunganController::class, 'generateImage']);


    // Kelola Santri
    Route::resource('/santri', SantriController::class);
   
   // Kelola Infaq
Route::get('/infaq/export', [InfaqController::class, 'export'])->name('infaq.export');
Route::get('/laporan-infaq', [LaporanController::class, 'laporanInfaq'])->name('laporan.infaq');

Route::get('/infaq', [InfaqController::class, 'index'])->name('infaq.index');
Route::get('/infaq/create', [InfaqController::class, 'create'])->name('infaq.create');
Route::post('/infaq', [InfaqController::class, 'store'])->name('infaq.store');
Route::get('/infaq/{id}/edit', [InfaqController::class, 'edit'])->name('infaq.edit');
Route::put('/infaq/{id}', [InfaqController::class, 'update'])->name('infaq.update');
Route::delete('/infaq/{id}', [InfaqController::class, 'destroy'])->name('infaq.destroy');
Route::get('/infaq/{id}', [InfaqController::class, 'show'])->name('infaq.show');
Route::post('/infaq/update-jumlah', [InfaqController::class, 'updateJumlahInfaq'])->name('infaq.updateJumlah');
Route::get('/infaq/setting', [InfaqController::class, 'showSettingForm'])->name('infaq.setting');
Route::post('/infaq/setting', [InfaqController::class, 'storeSetting'])->name('infaq.setting.store');
Route::get('/infaq/list/{bulan}', [InfaqController::class, 'showList'])->name('infaq.list');
Route::post('/infaq/bayar/{id}', [InfaqController::class, 'bayarInfaq'])->name('infaq.bayar');
Route::patch('/infaq/batal/{id}', [InfaqController::class, 'batalBayar'])->name('infaq.batal');
Route::get('/infaq/detail/{santri}', [InfaqController::class, 'show'])->name('infaq.show');
Route::get('/infaq/{santri}/download', [InfaqController::class, 'download'])->name('infaq.download');
Route::delete('/infaq/setting/{id}', [InfaqController::class, 'destroySetting'])->name('infaq.setting.destroy');


    // Kelola Santri
    Route::get('/laporan-santri', [DataSantriController::class, 'laporan'])->name('santri.laporan');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kas', [LaporanController::class, 'kas'])->name('laporan.kas');
    Route::get('/laporan/kas/cetak', [LaporanController::class, 'cetakKas'])->name('laporan.kas.cetak');
    
    Route::middleware('auth')->group(function () {

    // ==== Rute Profil Bendahara ====
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password', function () {
        return view('profile.password');
    })->name('profile.password');

    Route::post('/profile/password', function (Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    })->name('profile.password.update');

    // ==== Rute Profil Ketua Yayasan ====
    Route::get('/profile-ketua', [ProfilekController::class, 'show'])->name('profileketua.show');
    Route::get('/profile-ketua/edit', [ProfilekController::class, 'edit'])->name('profileketua.edit');
    Route::put('/profile-ketua/update', [ProfilekController::class, 'update'])->name('profileketua.update');

    Route::get('/profile-ketua/password', function () {
        return view('profileketua.password');
    })->name('profileketua.password');

    Route::post('/profile-ketua/password', function (Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profileketua.show')->with('success', 'Password berhasil diubah.');
    })->name('profileketua.password.update');
});
});
    $user = Session::get('user');

// Untuk menyimpan data ke session
    Session::put('user', $user);


    Route::post('/logout', function () {Auth::logout();  // Logout user
    return redirect ('/');  // Redirect ke halaman utama setelah logout
    })->name('logout');  // Memberikan nama pada route logout

    