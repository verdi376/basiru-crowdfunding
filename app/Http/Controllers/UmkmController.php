<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;

class UmkmController extends Controller
{
    // Menampilkan form pembuatan profil UMKM
    public function create()
    {
        return view('umkm.create');
    }

   
     // Menyimpan data profil UMKM
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'kategori', 'deskripsi', 'lokasi', 'kontak']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($data);

        return redirect()->route('umkm.profil')->with('success', 'Profil UMKM berhasil dibuat.');
    }

    // Menampilkan profil UMKM milik user login
    public function profil()
{
    $umkm = Auth::user()->umkm;
    return view('umkm.profil', compact('umkm')); // WAJIB ada $umkm
}


    // Menampilkan form edit profil UMKM
    public function edit()
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.create');
        }

        return view('umkm.edit', compact('umkm'));
    }

    // Menyimpan update data UMKM
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

    // Update semua kolom
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



    // Menampilkan saldo user
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
