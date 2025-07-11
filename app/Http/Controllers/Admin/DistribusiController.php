<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::query();
        if ($request->q) {
            $query->where('nama', 'like', '%'.$request->q.'%');
        }
        $umkms = $query->withCount(['investors as jumlah_investor'])->get();
        // status_distribusi: anggap ada field di tabel umkms, jika belum ada, bisa pakai logika lain
        return view('admin.distribusi', compact('umkms'));
    }

    public function proses(Request $request, Umkm $umkm)
    {
        DB::beginTransaction();
        try {
            $totalDana = $umkm->dana_terkumpul;
            $adminFee = $totalDana * ($umkm->persentase_admin / 100);
            $danaDistribusi = $totalDana - $adminFee;
            $investors = $umkm->investors;
            $jumlahInvestor = $investors->count();
            $perInvestor = $jumlahInvestor > 0 ? floor($danaDistribusi / $jumlahInvestor) : 0;
            // Simpan distribusi ke setiap investor (bisa buat tabel distribusi jika perlu)
            foreach ($investors as $investor) {
                // Contoh: buat transaksi distribusi
                Transaksi::create([
                    'user_id' => $investor->id,
                    'umkm_id' => $umkm->id,
                    'jenis' => 'distribusi',
                    'jumlah' => $perInvestor,
                    'status' => 'selesai',
                    'sisa_saldo' => $investor->saldo + $perInvestor,
                ]);
                // Update saldo investor
                $investor->saldo += $perInvestor;
                $investor->save();
            }
            // Simpan fee admin (bisa ke user admin atau log distribusi)
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->saldo += $adminFee;
                $admin->save();
            }
            // Update status distribusi UMKM
            $umkm->status_distribusi = 'selesai';
            $umkm->save();
            DB::commit();
            return redirect()->route('admin.distribusi')->with('success', 'Distribusi dana berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Distribusi gagal: '.$e->getMessage());
        }
    }

    public function dashboard()
    {
        // Data investor lengkap
        $investors = User::where('role', 'investor')->get()->map(function($investor) {
            $jumlah_dana = $investor->transaksis()
                ->where('jenis', 'investasi')
                ->where('status', 'diterima')
                ->sum('jumlah');
            $jumlah_umkm = $investor->transaksis()
                ->where('jenis', 'investasi')
                ->where('status', 'diterima')
                ->distinct('umkm_id')
                ->count('umkm_id');
            $investor->jumlah_dana = $jumlah_dana;
            $investor->jumlah_umkm = $jumlah_umkm;
            return $investor;
        });
        // Data UMKM lengkap (termasuk durasi investasi)
        $umkms = Umkm::all();
        // Data statistik
        $totalInvestor = $investors->count();
        $totalUmkm = $umkms->count();
        $totalDana = Transaksi::where('jenis', 'investasi')->where('status', 'diterima')->sum('jumlah');
        $totalTransaksi = Transaksi::count();
        return view('admin.dashboard', compact('investors', 'umkms', 'totalInvestor', 'totalUmkm', 'totalDana', 'totalTransaksi'));
    }
}
