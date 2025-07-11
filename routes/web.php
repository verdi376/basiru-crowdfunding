<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\AdminController;
use App\Models\Transaksi;
use App\Models\Umkm;
use App\Models\User;
use App\Http\Controllers\Umkm\LaporanPenjualanController;

// === HOME REDIRECT ===
Route::get('/', fn () => redirect('/login'));

// === DASHBOARD REDIRECT SESUAI ROLE ===
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'investor') {
        return redirect()->route('investor.dashboard');
    } elseif ($user->role === 'umkm') {
        return redirect()->route('umkm.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Dashboard umum (jika ada)
    $query = request('q');
    $umkms = Umkm::when($query, function ($q) use ($query) {
        $q->where('nama', 'like', "%$query%")
          ->orWhere('kategori', 'like', "%$query%")
          ->orWhere('lokasi', 'like', "%$query%");
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
    Route::get('/dashboard', [InvestorController::class, 'dashboard'])->name('investor.dashboard');
    Route::get('/saldo', [InvestorController::class, 'saldo'])->name('investor.saldo');
    Route::get('/transaksi', [InvestorController::class, 'transaksi'])->name('investor.transaksi');
    Route::post('/transaksi', [InvestorController::class, 'store'])->name('investor.transaksi.store');
    Route::get('/transaksi/{id}/qr', [InvestorController::class, 'showQr'])->name('investor.transaksi.qr');
    Route::post('/topup', [InvestorController::class, 'topup'])->name('investor.topup');
    Route::post('/topup/confirm', [InvestorController::class, 'confirmTopUp'])->name('investor.topup.confirm');
    Route::post('/topup/process', [InvestorController::class, 'processTopUp'])->name('investor.topup.process');
    Route::get('/metode-pembayaran', [InvestorController::class, 'metodePembayaran'])->name('investor.metode_pembayaran');
    Route::get('/qr-pembayaran', [InvestorController::class, 'qrPembayaran'])->name('investor.qr_pembayaran');
    Route::post('/tarik', [InvestorController::class, 'tarik'])->name('investor.tarik');

    // Portofolio
    Route::prefix('portofolio')->group(function () {
        Route::get('/', [PortofolioController::class, 'index'])->name('portofolios.index');
        Route::get('/create', [PortofolioController::class, 'create'])->name('portofolios.create');
        Route::post('/', [PortofolioController::class, 'store'])->name('portofolios.store');
        Route::get('/{portofolio}', [PortofolioController::class, 'show'])->name('portofolios.show');
        Route::get('/{portofolio}/edit', [PortofolioController::class, 'edit'])->name('portofolios.edit');
        Route::put('/{portofolio}', [PortofolioController::class, 'update'])->name('portofolios.update');
        Route::delete('/{portofolio}', [PortofolioController::class, 'destroy'])->name('portofolios.destroy');
    });
});

// === PROFIL ===
Route::middleware('auth')->prefix('profil')->group(function () {
    Route::get('/akun', [ProfilController::class, 'index'])->name('profil.akun');
    Route::put('/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// === TENTANG & BANTUAN ===
Route::get('/tentang', fn () => view('profil.tentang'))->middleware('auth')->name('tentang');
Route::get('/bantuan', fn () => view('profil.bantuan'))->middleware('auth')->name('bantuan');

// === UMKM ===
Route::middleware(['auth'])->group(function () {
    Route::get('/umkm/dashboard', [UmkmController::class, 'dashboard'])->name('umkm.dashboard');
    Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/profil', [UmkmController::class, 'profil'])->name('umkm.profil');
    Route::get('/umkm/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm/update', [UmkmController::class, 'update'])->name('umkm.update');
    // Route::delete(uri: '/umkm/delete', [UmkmController::class, 'destroy'])->name('umkm.destroy');
    Route::get('/umkm/saldo', [UmkmController::class, 'saldo'])->name('umkm.saldo');
    Route::get('/umkm/transaksi', [UmkmController::class, 'transaksi'])->name('umkm.transaksi');
});
// === LAPORAN UMKM ===
Route::middleware(['auth'])->prefix('umkm')->group(function () {
    Route::get('/laporan', [LaporanPenjualanController::class, 'index'])->name('umkm.laporan.index');
    // Tambahan lainnya jika kamu punya: buat, simpan, lihat, dll
});

// === ADMIN DASHBOARD ===
Route::get('/admin/dashboard', function () {
    Transaksi::where('status', 'pending')->update(['status' => 'ditolak']);

    $investors = User::where('role', 'investor')
        ->select('id', 'name', 'created_at')
        ->withCount(['transaksis as jumlah_dana' => function ($q) {
            $q->where('jenis', 'investasi')
              ->where('status', 'disetujui')
              ->select(DB::raw("SUM(jumlah)")); // ✅ DIGANTI DARI nominal KE jumlah
        }])
        ->withCount(['transaksis as jumlah_umkm' => function ($q) {
            $q->where('jenis', 'investasi')
              ->where('status', 'disetujui')
              ->select(DB::raw("COUNT(DISTINCT umkm_id)"));
        }])
        ->get();

    return view('admin.dashboard', [
        'transaksis' => Transaksi::all(),
        'umkms' => Umkm::all(),
        'investors' => $investors,
    ]);
})->middleware('auth')->name('admin.dashboard');

// === ADMIN ROUTES ===
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/distribusi', [App\Http\Controllers\Admin\DistribusiController::class, 'index'])->name('admin.distribusi');
    Route::post('/distribusi/{umkm}/proses', [App\Http\Controllers\Admin\DistribusiController::class, 'proses'])->name('admin.distribusi.proses');

    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanPenjualanController::class, 'index'])->name('admin.laporan.index');
    Route::post('/laporan/{id}/verifikasi', [App\Http\Controllers\Admin\LaporanPenjualanController::class, 'verifikasi'])->name('admin.laporan.verifikasi');

    Route::get('/deviden', [App\Http\Controllers\Admin\DevidenController::class, 'index'])->name('admin.deviden.index');
    Route::post('/deviden/{id}/distribute', [App\Http\Controllers\Admin\DevidenController::class, 'distribute'])->name('admin.deviden.distribute');

    Route::post('/update-password', fn () => 'dummy')->name('admin.updatePassword');
});
