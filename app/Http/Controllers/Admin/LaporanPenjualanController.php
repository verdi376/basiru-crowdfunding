<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;
use App\Models\Umkm;
use Illuminate\Support\Facades\Storage;

class LaporanPenjualanController extends Controller
{
    public function index()
    {
        $laporans = LaporanPenjualan::with('umkm')->latest()->get();
        return view('admin.laporan_penjualan', compact('laporans'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'keterangan' => 'nullable|string',
        ]);
        $laporan = LaporanPenjualan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->keterangan = $request->keterangan;
        $laporan->save();
        // TODO: Notifikasi ke UMKM (opsional)
        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function download($id)
    {
        $laporan = LaporanPenjualan::findOrFail($id);
        if (!Storage::exists($laporan->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        return Storage::download($laporan->file_path);
    }
}
