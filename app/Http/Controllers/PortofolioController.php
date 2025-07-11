<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PortofolioController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $portofolio = $user->portofolio; // relasi hasOne
        // Ambil data investasi UMKM user
        $investasiUmkms = \App\Models\Transaksi::with('umkm')
            ->where('user_id', $user->id)
            ->where('jenis', 'investasi')
            ->get()
            ->groupBy('umkm_id')
            ->map(function($group) {
                $first = $group->first();
                return (object)[
                    'umkm' => $first->umkm,
                    'total_investasi' => $group->sum('jumlah'),
                    'tanggal_mulai' => $group->min('created_at'),
                    'status' => $first->status,
                    'estimasi_bagi_hasil' => $first->estimasi_bagi_hasil ?? 0,
                ];
            })->values();
        return view('portofolios.index', compact('portofolio', 'investasiUmkms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portofolios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'no_telepon' => 'required|string|max:20',
        'alamat' => 'required|string',
        'pekerjaan' => 'required|string|max:255',
        'penghasilan' => 'required|numeric',
    ]);

    $data = $request->all();
    $data['user_id'] = Auth::id();

    Portofolio::create($data);

    return redirect()->route('portofolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portofolio $portofolio)
    {
        // $this->authorize('view', $portofolio);
        return view('portofolios.show', compact('portofolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portofolio $portofolio)
    {
        // $this->authorize('update', $portofolio);
        return view('portofolios.edit', compact('portofolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portofolio $portofolio)
    {
        // $this->authorize('update', $portofolio);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'penghasilan' => 'required|numeric|min:0',
        ]);

        $data = $request->only([
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'no_telepon',
            'alamat',
            'pekerjaan',
            'penghasilan'
        ]);
        $portofolio->update($data);

        return redirect()->route('portofolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portofolio $portofolio)
    {
        // $this->authorize('delete', $portofolio);
        $portofolio->delete();
        return redirect()->route('portofolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}
