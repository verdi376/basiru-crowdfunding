<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Transaksi;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard
    public function index()
    {
        $totalUmkm = Umkm::count();
        $totalInvestor = User::where('role', 'investor')->count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::where('status', 'sukses')->sum('jumlah');
        
        $umkmBaru = Umkm::latest()->take(5)->get();
        $transaksiTerbaru = Transaksi::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard.index', compact(
            'totalUmkm', 
            'totalInvestor', 
            'totalTransaksi', 
            'totalPendapatan',
            'umkmBaru',
            'transaksiTerbaru'
        ));
    }
    
    // Alias untuk kompatibilitas
    public function dashboard()
    {
        return $this->index();
    }

    // Data UMKM
    public function dataUmkm()
    {
        $umkms = Umkm::with('user')->latest()->paginate(10);
        return view('admin.umkm.index', compact('umkms'));
    }

    public function showUmkm($id)
    {
        $umkm = Umkm::with('user')->findOrFail($id);
        return view('admin.umkm.show', compact('umkm'));
    }
    
    public function editUmkm($id)
    {
        $umkm = Umkm::with('user')->findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }
    
    public function updateUmkm(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'dana_dibutuhkan' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,aktif,ditolak,nonaktif',
            'catatan_penolakan' => 'nullable|string|max:1000',
        ]);
        
        $umkm = Umkm::findOrFail($id);
        $umkm->update($request->only([
            'nama', 'deskripsi', 'alamat', 'telepon', 'kategori', 
            'lokasi', 'kontak', 'dana_dibutuhkan', 'status', 'catatan_penolakan'
        ]));
        
        return redirect()->route('admin.umkm.show', $umkm->id)
            ->with('success', 'Data UMKM berhasil diperbarui');
    }

    public function verifikasiUmkm(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,aktif,ditolak,nonaktif',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->status = 'aktif';
        
        // Simpan catatan jika ada
        if ($request->filled('catatan')) {
            $umkm->catatan_verifikasi = $request->catatan;
        }
        
        $umkm->save();

        return back()->with('success', 'UMKM berhasil diverifikasi');
    }
    
    public function tolakUmkm(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->status = 'ditolak';
        $umkm->catatan_penolakan = $request->catatan;
        $umkm->save();

        return back()->with('success', 'Verifikasi UMKM berhasil ditolak');
    }

    public function hapusUmkm($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->delete();

        return back()->with('success', 'UMKM berhasil dihapus');
    }

    // Data Investor
    public function dataInvestor()
    {
        $investors = User::where('role', 'investor')
            ->withCount('investments')
            ->latest()
            ->paginate(10);
            
        return view('admin.investor.index', compact('investors'));
    }

    public function showInvestor($id)
    {
        $investor = User::with(['investments.umkm'])->findOrFail($id);
        return view('admin.investor.show', compact('investor'));
    }

    public function verifikasiInvestor(Request $request, $id)
    {
        $investor = User::findOrFail($id);
        $investor->is_verified = $request->is_verified;
        $investor->save();

        return back()->with('success', 'Status verifikasi investor berhasil diperbarui');
    }

    public function hapusInvestor($id)
    {
        $investor = User::findOrFail($id);
        $investor->delete();

        return back()->with('success', 'Investor berhasil dihapus');
    }

    // Laporan
    public function laporanTransaksi()
    {
        $transaksis = Transaksi::with(['user', 'metodePembayaran'])
            ->latest()
            ->paginate(15);
            
        return view('admin.laporan.transaksi', compact('transaksis'));
    }

    // Pengaturan
    public function pengaturanUmum()
    {
        $settings = [
            'nama_aplikasi' => config('app.name'),
            'email_admin' => config('mail.from.address'),
            'telepon_admin' => config('app.phone'),
            'alamat_kantor' => config('app.address'),
            'biaya_admin' => config('app.admin_fee'),
            'maks_investasi' => config('app.max_investment'),
        ];
        
        return view('admin.pengaturan.umum', compact('settings'));
    }

    public function updatePengaturanUmum(Request $request)
    {
        $validated = $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'email_admin' => 'required|email',
            'telepon_admin' => 'required|string',
            'alamat_kantor' => 'required|string',
            'biaya_admin' => 'required|numeric|min:0',
            'maks_investasi' => 'required|numeric|min:100000',
        ]);

        // Simpan ke file .env atau database
        // ...

        return back()->with('success', 'Pengaturan umum berhasil diperbarui');
    }

    public function metodePembayaran()
    {
        $metodes = MetodePembayaran::all();
        return view('admin.pengaturan.metode-pembayaran', compact('metodes'));
    }

    public function tambahMetodePembayaran(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|unique:metode_pembayaran,kode',
            'tipe' => 'required|in:bank,ewallet,qris',
            'nomor_rekening' => 'required_if:tipe,bank|nullable|string',
            'atas_nama' => 'required_if:tipe,bank|nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/metode-pembayaran');
            $validated['logo'] = str_replace('public/', '', $path);
        }

        MetodePembayaran::create($validated);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function updateMetodePembayaran(Request $request, $id)
    {
        $metode = MetodePembayaran::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|unique:metode_pembayaran,kode,' . $id,
            'tipe' => 'required|in:bank,ewallet,qris',
            'nomor_rekening' => 'required_if:tipe,bank|nullable|string',
            'atas_nama' => 'required_if:tipe,bank|nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($metode->logo) {
                Storage::delete('public/' . $metode->logo);
            }
            
            $path = $request->file('logo')->store('public/metode-pembayaran');
            $validated['logo'] = str_replace('public/', '', $path);
        }

        $metode->update($validated);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui');
    }

    public function hapusMetodePembayaran($id)
    {
        $metode = MetodePembayaran::findOrFail($id);
        
        // Hapus logo jika ada
        if ($metode->logo) {
            Storage::delete('public/' . $metode->logo);
        }
        
        $metode->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
