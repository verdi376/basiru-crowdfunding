<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;
use App\Models\Transaksi;

class UmkmController extends Controller
{
    // ✅ Cegah user yang sudah punya UMKM dari akses form
    public function create()
    {
        if (auth()->user()->umkm) {
            return redirect()->route('umkm.index')->with('error', 'Kamu sudah memiliki profil UMKM.');
        }

        return view('umkm.create');
    }

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

    public function profil()
    {
        $umkm = Auth::user()->umkm;
        return view('umkm.profil', compact('umkm'));
    }

    public function edit()
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.create');
        }

        return view('umkm.edit', compact('umkm'));
    }

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
            return redirect()->route('umkm.create');
        }

        $umkm->nama = $request->nama;
        $umkm->kategori = $request->kategori;
        $umkm->deskripsi = $request->deskripsi;
        $umkm->lokasi = $request->lokasi;
        $umkm->kontak = $request->kontak;

        if ($request->hasFile('foto')) {
            $umkm->foto = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->save();

        return redirect()->route('umkm.profil')->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    public function destroy()
    {
        $umkm = Auth::user()->umkm;

        if ($umkm) {
            $umkm->delete();
            return redirect()->route('umkm.create')->with('success', 'UMKM berhasil dihapus.');
        }

        return redirect()->route('umkm.profil')->with('error', 'UMKM tidak ditemukan.');
    }

    public function saldo()
    {
        $saldo = Auth::user()->saldo ?? 0;
        return view('umkm.saldo', compact('saldo'));
    }

    public function index()
    {
        $umkm = Auth::user()->umkm;
        return view('umkm.index', compact('umkm'));
    }
}
