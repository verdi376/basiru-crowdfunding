<?php

namespace App\Http\Controllers;
 use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function saldo()
{
    $user = Auth::user();
    $saldo = $user->saldo ?? 0;
    $recentTransaksis = $user->transaksis()->latest()->take(5)->get();

    return view('investor.saldo', compact('saldo', 'recentTransaksis'));
}


   public function transaksi()
    {
        $user = Auth::user();
        $transaksis = $user->transaksis()->latest()->get();
        return view('investor.transaksi', compact('transaksis'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:donasi,topup',
            'jumlah' => 'required|numeric|min:1000',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $path = $request->file('bukti')?->store('bukti-transaksi', 'public');

        Transaksi::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'bukti' => $path,
            'deskripsi' => $request->jenis === 'topup' ? 'Top-up saldo' : 'Donasi ke campaign',
        ]);

        return back()->with('success', 'Transaksi berhasil dikirim. Menunggu konfirmasi.');
    }

}
