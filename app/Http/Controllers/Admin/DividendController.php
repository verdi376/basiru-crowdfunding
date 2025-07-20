<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DividendPayment;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DividendController extends Controller
{
    public function index()
    {
        $payments = DividendPayment::with(['investor', 'umkm'])
            ->latest()
            ->paginate(20);
            
        return view('admin.dividends.index', compact('payments'));
    }

    public function processDividends(Umkm $umkm, $period)
    {
        // Validasi periode (format: YYYY-MM)
        if (!preg_match('/^\d{4}-\d{2}$/', $period)) {
            return back()->with('error', 'Format periode tidak valid. Gunakan format YYYY-MM');
        }

        // Hitung total keuntungan UMKM untuk periode tersebut
        $profit = $umkm->laporanPenjualan()
            ->whereYear('periode_awal', '=', substr($period, 0, 4))
            ->whereMonth('periode_awal', '=', substr($period, 5, 2))
            ->sum('total_keuntungan');

        if ($profit <= 0) {
            return back()->with('error', 'Tidak ada keuntungan yang bisa dibagikan untuk periode ini');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Dapatkan semua investor UMKM ini
            $investors = $umkm->investors()->wherePivot('status', 'active')->get();
            
            foreach ($investors as $investor) {
                // Hitung jumlah yang didapat investor berdasarkan persentase kepemilikan
                $investment = $investor->investments()
                    ->where('umkm_id', $umkm->id)
                    ->where('status', 'active')
                    ->first();
                
                if ($investment) {
                    $dividendAmount = ($profit * $investment->percentage) / 100;
                    
                    // Buat catatan pembayaran deviden
                    DividendPayment::create([
                        'investor_id' => $investor->id,
                        'umkm_id' => $umkm->id,
                        'amount' => $dividendAmount,
                        'period' => $period,
                        'status' => 'pending',
                        'notes' => "Pembagian dividen periode $period"
                    ]);
                    
                    // Tambahkan saldo ke investor
                    $investor->increment('saldo', $dividendAmount);
                }
            }

            DB::commit();
            return back()->with('success', 'Pembagian dividen berhasil diproses');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function processCapitalReturn(Umkm $umkm)
    {
        // Periksa apakah periode investasi sudah berakhir
        if (now()->lt($umkm->investment_period_end)) {
            return back()->with('error', 'Periode investasi belum berakhir');
        }

        DB::beginTransaction();

        try {
            $investors = $umkm->investors()->wherePivot('status', 'active')->get();
            
            foreach ($investors as $investor) {
                $investment = $investor->investments()
                    ->where('umkm_id', $umkm->id)
                    ->where('status', 'active')
                    ->first();
                
                if ($investment) {
                    // Buat catatan pengembalian modal
                    CapitalReturn::create([
                        'investor_id' => $investor->id,
                        'umkm_id' => $umkm->id,
                        'amount' => $investment->amount,
                        'status' => 'pending',
                        'notes' => 'Pengembalian modal investasi'
                    ]);
                    
                    // Tambahkan saldo ke investor
                    $investor->increment('saldo', $investment->amount);
                    
                    // Nonaktifkan investasi
                    $investment->update(['status' => 'completed']);
                }
            }

            // Nonaktifkan UMKM atau ubah statusnya
            $umkm->update(['status' => 'completed']);

            DB::commit();
            return back()->with('success', 'Pengembalian modal berhasil diproses');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Tandai pembayaran deviden sebagai sudah dibayar
     */
    public function markAsPaid(DividendPayment $payment)
    {
        if ($payment->status !== 'paid') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            return back()->with('success', 'Pembayaran deviden berhasil ditandai sebagai sudah dibayar');
        }
        
        return back()->with('error', 'Pembayaran sudah ditandai sebagai sudah dibayar');
    }
}
