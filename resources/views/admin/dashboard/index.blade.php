@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Hari Ini</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Minggu Ini</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Bulan Ini</button>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total UMKM</h6>
                        <h2 class="mb-0">{{ $totalUmkm }}</h2>
                    </div>
                    <i class="bi bi-shop fs-1 opacity-25"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.umkm.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Investor</h6>
                        <h2 class="mb-0">{{ $totalInvestor }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-25"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.investor.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Transaksi</h6>
                        <h2 class="mb-0">{{ number_format($totalTransaksi) }}</h2>
                    </div>
                    <i class="bi bi-cash-coin fs-1 opacity-25"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.laporan.transaksi') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Pendapatan</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <i class="bi bi-graph-up fs-1 opacity-25"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.laporan.transaksi') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar UMKM Baru -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">UMKM Terbaru</h5>
        <a href="{{ route('admin.umkm.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($umkmBaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama UMKM</th>
                            <th>Pemilik</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($umkmBaru as $umkm)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($umkm->logo)
                                            <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->nama }}" class="rounded me-2" width="40" height="40">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                <i class="bi bi-shop text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $umkm->nama }}</h6>
                                            <small class="text-muted">{{ $umkm->kategori }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $umkm->user->name }}</td>
                                <td>{{ $umkm->kategori }}</td>
                                <td>
                                    @if($umkm->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($umkm->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $umkm->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mb-0">Belum ada UMKM terdaftar</p>
            </div>
        @endif
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Transaksi Terbaru</h5>
        <a href="{{ route('admin.laporan.transaksi') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($transaksiTerbaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Pengguna</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $transaksi)
                            <tr>
                                <td>#{{ $transaksi->id }}</td>
                                <td>{{ $transaksi->user->name }}</td>
                                <td>{{ ucfirst($transaksi->jenis) }}</td>
                                <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                                <td>
                                    @if($transaksi->status == 'sukses')
                                        <span class="badge bg-success">Sukses</span>
                                    @elseif($transaksi->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mb-0">Belum ada transaksi</p>
            </div>
        @endif
    </div>
</div>
@endsection
