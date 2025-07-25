<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $umkm = Auth::user()->umkm;
        // Jika user belum punya profil UMKM, redirect dengan pesan error
        if (!$umkm) {
            return redirect()->route('umkm.profil')->with('error', 'Anda harus membuat profil UMKM terlebih dahulu.');
        }
        $laporans = LaporanPenjualan::where('umkm_id', $umkm->id)
                    ->latest()
                    ->paginate(10);
        return view('umkm.laporan.index', compact('laporans', 'umkm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $umkm = Auth::user()->umkm;
        
        if (!$umkm) {
            return redirect()->route('umkm.profil')->with('error', 'Anda harus membuat profil UMKM terlebih dahulu.');
        }
        return view('umkm.laporan.create', compact('umkm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
                'keterangan' => 'nullable|string',
                'total_penjualan' => 'required|numeric|min:0',
                'total_keuntungan' => 'required|numeric|min:0',
                'periode_awal' => 'required|date',
                'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            ]);

            $umkm = Auth::user()->umkm;
            if (!$umkm) {
                return redirect()->route('umkm.profil')
                    ->with('error', 'Anda harus membuat profil UMKM terlebih dahulu.');
            }

            // Proses upload file
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('laporan_penjualan', $fileName, 'public');

            if (!$filePath) {
                throw new \Exception('Gagal mengupload file.');
            }

            // Buat instance model
            $laporan = new LaporanPenjualan();
            $laporan->umkm_id = $umkm->id;
            $laporan->judul = $validated['judul'];
            $laporan->file = $filePath;
            $laporan->keterangan = $validated['keterangan'] ?? null;
            $laporan->total_penjualan = $validated['total_penjualan'];
            $laporan->total_keuntungan = $validated['total_keuntungan'];
            $laporan->periode_awal = $validated['periode_awal'];
            $laporan->periode_akhir = $validated['periode_akhir'];
            $laporan->status = 'menunggu';

            // Simpan ke database
            $laporan->save();

            return redirect()
                ->route('umkm.laporan.index')
                ->with('success', 'Laporan penjualan berhasil disimpan dan sedang menunggu verifikasi admin.');
                    
        } catch (\Exception $e) {
            // Hapus file yang sudah diupload jika terjadi error
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = LaporanPenjualan::where('id', $id)
            ->whereHas('umkm', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        // Pastikan file ada
        if (!Storage::exists('public/' . $laporan->file)) {
            return back()->with('error', 'File laporan tidak ditemukan.');
        }

        return view('umkm.laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laporan = LaporanPenjualan::where('id', $id)
            ->where('umkm_id', Auth::user()->umkm->id)
            ->where('status', 'menunggu') // Hanya bisa edit jika status masih menunggu
            ->firstOrFail();

        return view('umkm.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $laporan = LaporanPenjualan::where('id', $id)
            ->where('umkm_id', Auth::user()->umkm->id)
            ->where('status', 'menunggu') // Hanya bisa update jika status masih menunggu
            ->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,zip,rar|max:10240', // Opsional, maksimal 10MB
            'keterangan' => 'nullable|string',
            'total_penjualan' => 'required|numeric|min:0',
            'total_keuntungan' => 'required|numeric|min:0',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $data = [
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'total_penjualan' => $request->total_penjualan,
            'total_keuntungan' => $request->total_keuntungan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ];

        // Jika ada file baru diupload
        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::disk('public')->delete($laporan->file);
            
            // Upload file baru
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $data['file'] = $file->storeAs('laporan_penjualan', $fileName, 'public');
        }

        $laporan->update($data);

        return redirect()->route('umkm.laporan.index')
            ->with('success', 'Laporan penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = LaporanPenjualan::where('id', $id)
            ->where('umkm_id', Auth::user()->umkm->id)
            ->where('status', 'menunggu') // Hanya bisa hapus jika status masih menunggu
            ->firstOrFail();

        // Hapus file dari storage
        Storage::disk('public')->delete($laporan->file);
        
        $laporan->delete();

        return redirect()->route('umkm.laporan.index')
            ->with('success', 'Laporan penjualan berhasil dihapus.');
    }
}