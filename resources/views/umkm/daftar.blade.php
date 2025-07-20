@extends('layouts.app')

@section('title', 'Daftar UMKM')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Daftar UMKM</h2>
            <p class="text-muted">Berikut adalah daftar UMKM yang terdaftar di platform kami beserta total investasinya.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($umkms as $umkm)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($umkm->foto)
                                <img src="{{ asset('storage/' . $umkm->foto) }}" alt="{{ $umkm->nama }}" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="bi bi-shop fs-4 text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="card-title mb-0">{{ $umkm->nama }}</h5>
                                <span class="badge bg-primary">{{ $umkm->kategori }}</span>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted small mb-3">
                            <i class="bi bi-geo-alt-fill me-1"></i> {{ $umkm->lokasi }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Total Investasi</div>
                                <div class="h5 mb-0 fw-bold">Rp {{ number_format($umkm->total_investasi ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="text-muted small">Jumlah Investor</div>
                                <div class="h5 mb-0 fw-bold">{{ $umkm->total_investor ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada UMKM yang terdaftar.
                </div>
            </div>
        @endforelse
    </div>

    @if($umkms->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                {{ $umkms->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
