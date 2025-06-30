<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfilController;
use App\Models\Umkm;

// === HOME REDIRECT ===
Route::get('/', function () {
    return redirect('/login');
});

// === DASHBOARD UMKM ===
Route::get('/dashboard', function () {
    $query = request('q');
    $umkms = Umkm::when($query, function ($q) use ($query) {
        $q->where('nama', 'like', '%' . $query . '%')
          ->orWhere('kategori', 'like', '%' . $query . '%')
          ->orWhere('lokasi', 'like', '%' . $query . '%');
    })->get();

    return view('dashboard', compact('umkms'));
})->middleware('auth')->name('dashboard');

// === AUTH ===
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === INVESTOR ROUTES ===
Route::middleware(['auth'])->prefix('investor')->group(function () {
    Route::get('/saldo', [InvestorController::class, 'saldo'])->name('investor.saldo');
    Route::get('/transaksi', [InvestorController::class, 'transaksi'])->name('investor.transaksi');
    Route::post('/transaksi', [InvestorController::class, 'store'])->name('investor.transaksi.store');
    // Tambahkan validasi saldo di dalam controller
    Route::post('/investor/topup', [InvestorController::class, 'topup'])->name('investor.topup');
    Route::post('/investor/tarik', [InvestorController::class, 'tarik'])->name('investor.tarik');

});

// === PROFIL USER ===
Route::middleware('auth')->prefix('profil')->group(function () {
    Route::get('/akun', [ProfilController::class, 'index'])->name('profil.akun');
    Route::put('/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// === TENTANG & BANTUAN ===
Route::get('/tentang', fn () => view('profil.tentang'))->middleware('auth')->name('tentang');
Route::get('/bantuan', fn () => view('profil.bantuan'))->middleware('auth')->name('bantuan');

// === UMKM ROUTES ===
Route::middleware(['auth'])->prefix('umkm')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/profil', [UmkmController::class, 'profil'])->name('umkm.profil');
    Route::get('/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/store', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::post('/update', [UmkmController::class, 'update'])->name('umkm.update');
    Route::get('/saldo', [UmkmController::class, 'saldo'])->name('umkm.saldo');
    Route::get('/portofolio', [UmkmController::class, 'portofolio'])->name('umkm.portofolio');
    Route::delete('/hapus', [UmkmController::class, 'destroy'])->name('umkm.destroy');
});
