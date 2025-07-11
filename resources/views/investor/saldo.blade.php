@extends('layouts.app')

@section('title', 'Saldo Investor')

@section('content')
<div class="container py-4 animate__animated animate__fadeIn">

    {{-- Header --}}
    <div class="text-center mb-5">
        <img src="https://cdn-icons-png.flaticon.com/512/599/599995.png" width="80" class="mb-3 animate__animated animate__bounce" alt="Wallet Icon">
        <h2 class="fw-bold text-primary"><i class="bi bi-wallet2 me-2"></i> Dashboard Saldo</h2>
        <p class="text-muted">Kelola saldo kamu untuk berinvestasi dan mendukung UMKM.</p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Grid Layout --}}
    <div class="row g-4">

        {{-- Card Saldo --}}
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4 bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Sisa Saldo Anda</h5>
                    <h2 class="text-success fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                    <p class="text-muted small">Gunakan saldo untuk berinvestasi atau ditarik kembali kapan saja.</p>
                    <a href="{{ route('investor.transaksi') }}" class="btn btn-outline-success mt-3 w-100">
                        <i class="bi bi-graph-up-arrow me-1"></i> Investasi Sekarang
                    </a>
                </div>
            </div>
        </div>

        {{-- Form Top Up / Tarik --}}
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3">Kelola Saldo</h5>

                    {{-- Top Up --}}
                    <form action="{{ route('investor.topup.confirm') }}" method="POST" class="mb-4">
                        @csrf
                        <label class="form-label">Top Up Saldo</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-plus-circle"></i></span>
                            <input type="number" name="nominal" class="form-control" placeholder="Minimal 10.000" min="10000" required>
                        </div>
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-arrow-up-circle me-1"></i> Lanjut ke Pembayaran
                        </button>
                    </form>

                    {{-- Tarik Saldo --}}
                    <form action="{{ route('investor.tarik') }}" method="POST" onsubmit="return confirm('Yakin ingin menarik saldo?')">
                        @csrf
                        <label class="form-label">Tarik Saldo</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-dash-circle"></i></span>
                            <input type="number" name="jumlah" class="form-control" placeholder="Minimal 10.000" min="10000" max="{{ $saldo }}" required>
                        </div>
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-cash-coin me-1"></i> Tarik Dana
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="col-12">
            <div class="alert alert-info shadow-sm rounded-3 animate__animated animate__fadeInUp">
                <i class="bi bi-info-circle me-2"></i> Semua transaksi dicatat dan dapat dilihat di 
                <a href="{{ route('investor.transaksi') }}">riwayat transaksi</a>.
            </div>
        </div>
    </div>
</div>
@endsection
