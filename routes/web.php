<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfilController;
use App\Models\Umkm;

// // === BERANDA ===
// Route::get('/', function () {
//     $umkms = Umkm::all();
//     return view('beranda', compact('umkms'));
// })->name('beranda');

Route::get('/', function(){
    return redirect('/login');
});

// === DASHBOARD ===
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

// === INVESTOR ===
Route::middleware(['auth'])->prefix('investor')->group(function () {
    Route::get('/saldo', [InvestorController::class, 'saldo'])->name('investor.saldo');
    Route::get('/transaksi', [InvestorController::class, 'transaksi'])->name('investor.transaksi');
    Route::post('/transaksi', [InvestorController::class, 'store'])->name('investor.transaksi.store');
});

// === UMKM ===
// Route::middleware(['auth'])->prefix('umkm')->group(function () {
//     Route::get('/profil', [UmkmController::class, 'profil'])->name('umkm.profil');
//     Route::get('/profil/edit', [UmkmController::class, 'edit'])->name('umkm.profil.edit');
//     Route::put('/profil/update', [UmkmController::class, 'update'])->name('umkm.profil.update');
//     Route::get('/saldo', [UmkmController::class, 'saldo'])->name('umkm.saldo');
//     Route::get('/profil/create', [UmkmController::class, 'create'])->name('umkm.profil.create');
//     Route::post('/profil', [UmkmController::class, 'store'])->name('umkm.profil.store');
//     Route::get('/profil/index', [UmkmController::class, 'index'])->name('umkm.profil.index');
//     Route::get('/profil/{id}', [UmkmController::class, 'show'])->name('umkm.profil.detail');
// });

// === PROFIL USER ===
Route::middleware('auth')->prefix('profil')->group(function () {
    Route::get('/akun', [ProfilController::class, 'index'])->name('profil.akun');
    Route::put('/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// === TENTANG & BANTUAN ===
Route::get('/tentang', function () {
    return view('profil.tentang');
})->middleware('auth')->name('tentang');

Route::get('/bantuan', function () {
    return view('profil.bantuan');
})->middleware('auth')->name('bantuan');

// === RESOURCE ===
Route::middleware(['auth'])->group(function () {
    Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/profil', [UmkmController::class, 'profil'])->name('umkm.profil');
    Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm/store', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::post('/umkm/update', [UmkmController::class, 'update'])->name('umkm.update');
    Route::get('/umkm/saldo', [UmkmController::class, 'saldo'])->name('umkm.saldo');
    Route::get('/umkm/portofolio', [UmkmController::class, 'portofolio'])->name('umkm.portofolio');
});