<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;
use App\Models\Transaksi;

class UmkmController extends Controller
{
    // ✅ Dashboard UMKM
    public function dashboard()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.create')->with('error', 'Silakan buat profil UMKM terlebih dahulu.');
        }

        $investasiMasuk = Transaksi::where('umkm_id', $umkm->id)
            ->where('jenis', 'investasi')
            ->where('status', 'diterima')
            ->latest()
            ->get();

        $totalDanaMasuk = $investasiMasuk->sum('jumlah');

        return view('umkm.dashboard', compact('user', 'umkm', 'investasiMasuk', 'totalDanaMasuk'));
    }

    // ✅ Form Buat UMKM
    public function create()
    {
        if (Auth::user()->umkm) {
            return redirect()->route('umkm.dashboard')->with('error', 'Kamu sudah memiliki profil UMKM.');
        }

        return view('umkm.create');
    }

    // ✅ Simpan Data UMKM Baru
    public function store(Request $request)
    {
        if (Auth::user()->umkm) {
            return redirect()->back()->with('error', 'Kamu sudah membuat UMKM. Tidak bisa membuat lebih dari satu.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dana_dibutuhkan' => 'required|numeric|min:1000',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('foto')?->store('umkm-foto', 'public');

        Umkm::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'dana_dibutuhkan' => $request->dana_dibutuhkan,
            'foto' => $path,
        ]);

        return redirect()->route('umkm.profil')->with('success', 'UMKM berhasil dibuat!');
    }

    // ✅ Tampilkan Profil UMKM
    public function profil()
    {
        $umkm = Auth::user()->umkm;
        return view('umkm.profil', compact('umkm'));
    }

    // ✅ Form Edit Profil UMKM
    public function edit()
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.create');
        }

        return view('umkm.edit', compact('umkm'));
    }

    // ✅ Simpan Perubahan Edit
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.create')->with('error', 'UMKM tidak ditemukan.');
        }

        $umkm->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kontak' => $request->kontak,
            'foto' => $request->hasFile('foto') 
                ? $request->file('foto')->store('umkm', 'public')
                : $umkm->foto,
        ]);

        return redirect()->route('umkm.profil')->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    // ✅ Hapus Profil UMKM
    public function destroy()
    {
        $umkm = Auth::user()->umkm;

        if ($umkm) {
            $umkm->delete();
            return redirect()->route('umkm.create')->with('success', 'UMKM berhasil dihapus.');
        }

        return redirect()->route('umkm.profil')->with('error', 'UMKM tidak ditemukan.');
    }

    // ✅ Cek Saldo (jika UMKM punya saldo)
    public function saldo()
    {
        $saldo = Auth::user()->saldo ?? 0;
        return view('umkm.saldo', compact('saldo'));
    }

    // ✅ Halaman Index UMKM (jika dibutuhkan)
    public function index()
    {
        $umkm = Auth::user()->umkm;
        return view('umkm.index', compact('umkm'));
    }

    // ✅ Halaman Transaksi UMKM
    public function transaksi()
    {
        $user = Auth::user();
        $umkm = $user->umkm;
        $transaksis = $umkm ? Transaksi::where('umkm_id', $umkm->id)->latest()->get() : collect();
        return view('umkm.transaksi', compact('umkm', 'transaksis'));
    }
}
