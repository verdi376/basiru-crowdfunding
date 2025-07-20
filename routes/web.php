<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Admin\DistribusiController;
use App\Http\Controllers\Admin\LaporanPenjualanController as AdminLaporanPenjualanController;
use App\Http\Controllers\Admin\DevidenController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Umkm\LaporanPenjualanController;
use App\Models\Transaksi;
use App\Models\Umkm;
use App\Models\User;

// === HOME ===
Route::get('/', fn () => redirect('/login'));

// === DASHBOARD REDIRECT (berdasarkan role) ===
Route::get('/daftar-umkm', [UmkmController::class, 'daftarUmkm'])->name('umkm.daftar');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'investor') {
        return redirect()->route('investor.dashboard');
    } elseif ($user->role === 'umkm') {
        return redirect()->route('umkm.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Default dashboard (jika role tidak dikenali)
    $query = request('q');
    $umkms = Umkm::when($query, function ($q) use ($query) {
        $q->where('nama', 'like', "%$query%")
          ->orWhere('kategori', 'like', "%$query%")
          ->orWhere('lokasi', 'like', "%$query%");
    })->get();

    return view('dashboard', compact('umkms'));
})->middleware('auth')->name('dashboard');

// === AUTHENTICATION ===
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

    // === PORTOFOLIO ===
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

// === PROFIL USER ===
Route::middleware('auth')->prefix('profil')->group(function () {
    Route::get('/akun', [ProfilController::class, 'index'])->name('profil.akun');
    Route::put('/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// === HALAMAN INFORMASI UMUM ===
Route::get('/tentang', fn () => view('profil.tentang'))->middleware('auth')->name('tentang');
Route::get('/bantuan', fn () => view('profil.bantuan'))->middleware('auth')->name('bantuan');

// === ADMIN ===
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Data Master
    Route::prefix('umkm')->group(function () {
        Route::get('/', [AdminController::class, 'dataUmkm'])->name('admin.umkm.index');
        Route::get('/{id}', [AdminController::class, 'showUmkm'])->name('admin.umkm.show');
        Route::get('/{id}/edit', [AdminController::class, 'editUmkm'])->name('admin.umkm.edit');
        Route::put('/{id}', [AdminController::class, 'updateUmkm'])->name('admin.umkm.update');
        Route::put('/{id}/verifikasi', [AdminController::class, 'verifikasiUmkm'])->name('admin.umkm.verifikasi');
        Route::put('/{id}/tolak', [AdminController::class, 'tolakUmkm'])->name('admin.umkm.tolak');
        Route::delete('/{id}', [AdminController::class, 'hapusUmkm'])->name('admin.umkm.hapus');
    });

    Route::prefix('investor')->group(function () {
        Route::get('/', [AdminController::class, 'dataInvestor'])->name('admin.investor.index');
        Route::get('/{id}', [AdminController::class, 'showInvestor'])->name('admin.investor.show');
        Route::put('/{id}/verifikasi', [AdminController::class, 'verifikasiInvestor'])->name('admin.investor.verifikasi');
        Route::delete('/{id}', [AdminController::class, 'hapusInvestor'])->name('admin.investor.hapus');
    });

    // Laporan
    Route::prefix('laporan')->group(function () {
        Route::get('/penjualan', [AdminLaporanPenjualanController::class, 'index'])->name('admin.laporan.penjualan');
        Route::get('/dividen', [DevidenController::class, 'index'])->name('admin.laporan.dividen');
        Route::post('/dividen/proses', [DevidenController::class, 'prosesDividen'])->name('admin.dividen.proses');
        Route::get('/transaksi', [AdminController::class, 'laporanTransaksi'])->name('admin.laporan.transaksi');
    });

    // Pengaturan
    Route::prefix('pengaturan')->group(function () {
        Route::get('/umum', [AdminController::class, 'pengaturanUmum'])->name('admin.pengaturan.umum');
        Route::put('/umum', [AdminController::class, 'updatePengaturanUmum'])->name('admin.pengaturan.umum.update');
        Route::get('/pembayaran', [AdminController::class, 'metodePembayaran'])->name('admin.pengaturan.pembayaran');
        Route::post('/pembayaran', [AdminController::class, 'tambahMetodePembayaran'])->name('admin.pengaturan.pembayaran.tambah');
        Route::put('/pembayaran/{id}', [AdminController::class, 'updateMetodePembayaran'])->name('admin.pengaturan.pembayaran.update');
        Route::delete('/pembayaran/{id}', [AdminController::class, 'hapusMetodePembayaran'])->name('admin.pengaturan.pembayaran.hapus');
    });
});

// === UMKM ===
Route::middleware(['auth'])->prefix('umkm')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('umkm.dashboard');
    Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/profil', [UmkmController::class, 'profil'])->name('umkm.profil');
    Route::get('/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/update', [UmkmController::class, 'update'])->name('umkm.update');
    Route::get('/saldo', [UmkmController::class, 'saldo'])->name('umkm.saldo');
    Route::get('/transaksi', [UmkmController::class, 'transaksi'])->name('umkm.transaksi');

    // FIXED: route destroy dengan parameter
    Route::delete('/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

    // === LAPORAN PENJUALAN ===
    Route::prefix('laporan')->name('umkm.laporan.')->group(function () {
        Route::get('/', [LaporanPenjualanController::class, 'index'])->name('index');
        Route::get('/create', [LaporanPenjualanController::class, 'create'])->name('create');
        Route::post('/', [LaporanPenjualanController::class, 'store'])->name('store');
        Route::get('/{id}', [LaporanPenjualanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [LaporanPenjualanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LaporanPenjualanController::class, 'update'])->name('update');
        Route::delete('/{id}', [LaporanPenjualanController::class, 'destroy'])->name('destroy');
    });
});

// Auto tolak transaksi pending (pindahkan ke controller)
Route::get('/admin/auto-reject', function () {
    $rejected = Transaksi::where('status', 'pending')->update(['status' => 'ditolak']);
    return back()->with('success', "$rejected transaksi pending ditolak otomatis");
})->name('admin.auto-reject');

// === ADMIN ROUTES ===
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/distribusi', [DistribusiController::class, 'index'])->name('distribusi');
        Route::post('/distribusi/{umkm}/proses', [DistribusiController::class, 'proses'])->name('distribusi.proses');

        Route::get('/laporan', [AdminLaporanPenjualanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/{id}/verifikasi', [AdminLaporanPenjualanController::class, 'verifikasi'])->name('laporan.verifikasi');
        Route::get('/laporan/{id}/download', [AdminLaporanPenjualanController::class, 'download'])->name('laporan.download');

        // Manajemen Deviden
        Route::prefix('dividends')->name('dividends.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DividendController::class, 'index'])->name('index');
            Route::post('/process', [\App\Http\Controllers\Admin\DividendController::class, 'processDividends'])->name('process');
            Route::post('/capital-return', [\App\Http\Controllers\Admin\DividendController::class, 'processCapitalReturn'])->name('capital.return');
            Route::put('/{payment}/mark-paid', [\App\Http\Controllers\Admin\DividendController::class, 'markAsPaid'])->name('mark-paid');
        });

        Route::post('/update-password', fn () => 'dummy')->name('updatePassword');
    });
