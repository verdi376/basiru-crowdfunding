<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Umkm;
use App\Models\ProfilInvestor;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Str;

class InvestorController extends Controller
{
    // ✅ DASHBOARD INVESTOR
  public function dashboard()
{
    $user = Auth::user();
    $saldo = $user->saldo ?? 0;
    $transaksis = $user->transaksis()->latest()->take(5)->get();

    // Ambil semua UMKM beserta dana terkumpul
    $umkms = Umkm::withSum(['transaksis as dana_terkumpul' => function ($q) {
        $q->where('jenis', 'investasi')->where('status', 'diterima');
    }], 'jumlah')->get();

    // UMKM yang sudah diinvestasikan oleh user ini
    $investasiUmkm = Transaksi::with('umkm')
        ->where('user_id', $user->id)
        ->where('jenis', 'investasi')
        ->where('status', 'diterima')
        ->get()
        ->groupBy('umkm_id');

    return view('investor.dashboard', compact('user', 'saldo', 'transaksis', 'investasiUmkm', 'umkms'));
}

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
        $user = Auth::user();

        if (!$user->profilInvestor) {
            return redirect()->route('profilInvestor.form')
                ->with('error', 'Lengkapi data diri terlebih dahulu sebelum berinvestasi.');
        }

        $request->validate([
            'jenis' => 'required|in:investasi',
            'jumlah' => 'required|numeric|min:1000',
            'umkm_id' => 'required|exists:umkms,id',
        ]);

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
        $request->validate(['jumlah' => 'required|numeric|min:10000']);

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
        $request->validate(['jumlah' => 'required|numeric|min:10000']);

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

    public function confirmTopUp(Request $request)
    {
        $request->validate(['nominal' => 'required|numeric|min:10000']);
        return view('investor.metode_pembayaran', ['nominal' => $request->nominal]);
    }

    public function processTopUp(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'metode' => 'required|string',
        ]);

        $user = Auth::user();
        $nominal = $request->nominal;
        $metode = $request->metode;
        $konfirmasi = $request->konfirmasi ?? 'qr';

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'jenis' => 'topup',
            'jumlah' => $nominal,
            'status' => 'pending',
            'deskripsi' => 'Top Up via ' . strtoupper($metode),
        ]);

        $qrText = $konfirmasi === 'qr'
            ? "TOPUP-{$metode}-{$transaksi->id}-{$nominal}"
            : "VA-{$metode}-{$transaksi->id}-" . random_int(100000000000, 999999999999);

        $fileName = "qr_" . Str::uuid() . ".png";

        // Generate QR code
        $qrResult = Builder::create()
            ->data($qrText)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->build();

        // Simpan QR code ke storage/app/public/qr/
        if (!Storage::disk('public')->exists('qr')) {
            Storage::disk('public')->makeDirectory('qr');
        }
        Storage::disk('public')->put('qr/' . $fileName, $qrResult->getString());

        // Simpan path QR di database
        $transaksi->qr_path = "storage/qr/" . $fileName;
        $transaksi->save();

        // Pass ke view
        $qrImagePath = asset('storage/qr/' . $fileName);
        return view('investor.qr_pembayaran', compact('nominal', 'metode', 'konfirmasi', 'qrText', 'qrImagePath'));
    }

    public function showQr($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (!$transaksi->qr_path) {
            return redirect()->route('investor.saldo')->with('error', 'QR Code tidak tersedia.');
        }

        $qrImagePath = asset($transaksi->qr_path);
        $nominal = $transaksi->jumlah;
        $metode = strtolower(str_replace('Top Up via ', '', $transaksi->deskripsi));
        $konfirmasi = 'qr';
        $qrText = 'TOPUP-' . $metode . '-' . $transaksi->id . '-' . $nominal;

        return view('investor.qr_pembayaran', compact('qrImagePath', 'nominal', 'metode', 'konfirmasi', 'qrText'));
    }
}
