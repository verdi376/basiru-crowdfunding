@extends('layouts.app')

@section('title', 'Distribusi Dana UMKM')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Distribusi Dana UMKM</h3>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Cari UMKM...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>UMKM</th>
                        <th>Durasi Investasi</th>
                        <th>Dana Terkumpul</th>
                        <th>Jumlah Investor</th>
                        <th>Status Distribusi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($umkms as $i => $umkm)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $umkm->nama }}</td>
                            <td>{{ $umkm->durasi_investasi }} bulan</td>
                            <td>Rp {{ number_format($umkm->dana_terkumpul, 0, ',', '.') }}</td>
                            <td>{{ $umkm->jumlah_investor ?? 0 }}</td>
                            <td>
                                @if($umkm->status_distribusi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($umkm->status_distribusi != 'selesai')
                                    <form method="POST" action="{{ route('admin.distribusi.proses', $umkm->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Distribusikan dana ke investor dan admin?')">Distribusi</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada UMKM</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
