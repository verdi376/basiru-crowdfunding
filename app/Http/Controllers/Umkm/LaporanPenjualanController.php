<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanPenjualanController extends Controller
{
    // Tampilkan semua laporan penjualan milik UMKM saat ini
    public function index()
    {
        $umkm = Auth::user()->umkm;

        // Jika user belum punya profil UMKM, redirect dengan pesan error
        if (!$umkm) {
            return redirect()->route('umkm.profil')->with('error', 'Kamu belum membuat profil UMKM.');
        }

        // Ambil semua laporan berdasarkan ID UMKM
        $laporans = LaporanPenjualan::where('umkm_id', $umkm->id)
                    ->latest()
                    ->get();

        return view('umkm.laporan', compact('laporans'));
    }

    // Simpan laporan PDF yang diunggah oleh UMKM
    public function store(Request $request)
    {
        $request->validate([
            'laporan_pdf' => 'required|file|mimes:pdf|max:2048',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('umkm.profil')->with('error', 'Kamu belum membuat profil UMKM.');
        }

        // Simpan file PDF ke folder storage/app/public/laporan
        $filePath = $request->file('laporan_pdf')->store('laporan', 'public');

        // Simpan data ke database
        LaporanPenjualan::create([
            'umkm_id'    => $umkm->id,
            'file'       => $filePath,
            'keterangan' => $request->keterangan,
            'status'     => 'menunggu',
        ]);

        return back()->with('success', 'Laporan berhasil diupload.');
    }
}
