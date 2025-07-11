<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\DevidenSchedule;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DevidenController extends Controller
{
    // Tampilkan jadwal deviden UMKM
    public function index()
    {
        $schedules = DevidenSchedule::with('umkm')->orderBy('jadwal_bagi')->get();
        return view('admin.deviden.index', compact('schedules'));
    }

    // Proses pembagian deviden (admin trigger)
    public function distribute(Request $request, $id)
    {
        $schedule = DevidenSchedule::findOrFail($id);
        if ($schedule->is_distributed) {
            return back()->with('error', 'Deviden sudah dibagikan.');
        }
        $umkm = $schedule->umkm;
        $totalKeuntungan = $request->input('total_keuntungan');
        $feeAdmin = $totalKeuntungan * ($umkm->persentase_admin / 100);
        $danaDistribusi = $totalKeuntungan - $feeAdmin;
        $investors = $umkm->transaksis()->where('jenis','investasi')->where('status','diterima')->get();
        $totalInvestasi = $investors->sum('jumlah');
        DB::beginTransaction();
        try {
            foreach ($investors as $investor) {
                $porsi = $totalInvestasi > 0 ? $investor->jumlah / $totalInvestasi : 0;
                $deviden = $danaDistribusi * $porsi;
                // Tambahkan saldo ke investor
                $user = User::find($investor->user_id);
                $user->saldo += $deviden;
                $user->save();
                // Catat transaksi deviden
                Transaksi::create([
                    'user_id' => $user->id,
                    'umkm_id' => $umkm->id,
                    'jenis' => 'deviden',
                    'jumlah' => $deviden,
                    'status' => 'selesai',
                    'deskripsi' => 'Pembagian deviden UMKM',
                ]);
            }
            // Tambahkan fee ke admin
            $admin = User::where('role','admin')->first();
            if ($admin) {
                $admin->saldo += $feeAdmin;
                $admin->save();
            }
            $schedule->update([
                'total_keuntungan' => $totalKeuntungan,
                'fee_admin' => $feeAdmin,
                'is_distributed' => true,
            ]);
            DB::commit();
            return back()->with('success', 'Deviden berhasil dibagikan ke investor dan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membagikan deviden: '.$e->getMessage());
        }
    }
}
