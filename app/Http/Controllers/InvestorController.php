<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Umkm;

class InvestorController extends Controller
{
    public function saldo()
    {
        $user = Auth::user();
        $saldo = $user->saldo ?? 0;
        $recentTransaksis = $user->transaksis()->latest()->take(5)->get();

        return view('investor.saldo', compact('saldo', 'recentTransaksis'));
    }

    public function transaksi(Request $request)
    {
        $user = Auth::user();
        $transaksis = $user->transaksis()->with('umkm')->latest()->get();
        $umkms = Umkm::all();
        $selectedUmkmId = $request->query('umkm_id');

        return view('investor.transaksi', compact('transaksis', 'umkms', 'selectedUmkmId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:investasi',
            'jumlah' => 'required|numeric|min:1000',
            'umkm_id' => 'required|exists:umkms,id',
        ]);

        $user = Auth::user();

        if ($user->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo kamu tidak mencukupi untuk melakukan investasi.');
        }

        $umkm = Umkm::findOrFail($request->umkm_id);
        $danaTerkumpul = $umkm->transaksis()
            ->where('jenis', 'investasi')
            ->where('status', 'diterima')
            ->sum('jumlah');

        if ($danaTerkumpul + $request->jumlah > $umkm->dana_dibutuhkan) {
            return back()->with('error', 'Dana UMKM ini sudah mencapai batas yang dibutuhkan.');
        }

        $user->saldo -= $request->jumlah;
        $user->save();

        Transaksi::create([
            'user_id' => $user->id,
            'jenis' => 'investasi',
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'umkm_id' => $request->umkm_id,
            'deskripsi' => 'Investasi ke UMKM',
        ]);

        return back()->with('success', 'Investasi berhasil dikirim dan sedang menunggu konfirmasi.');
    }

    public function topup(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $user->saldo += $request->jumlah;
        $user->save();

        Transaksi::create([
            'user_id' => $user->id,
            'jenis' => 'topup',
            'jumlah' => $request->jumlah,
            'status' => 'berhasil',
            'deskripsi' => 'Top Up Saldo',
        ]);

        return back()->with('success', 'Saldo berhasil ditambahkan.');
    }

    public function tarik(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();

        if ($user->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan.');
        }

        $user->saldo -= $request->jumlah;
        $user->save();

        Transaksi::create([
            'user_id' => $user->id,
            'jenis' => 'tarik',
            'jumlah' => $request->jumlah,
            'status' => 'berhasil',
            'deskripsi' => 'Penarikan saldo oleh investor',
        ]);

        return back()->with('success', 'Saldo berhasil ditarik.');
    }
}
