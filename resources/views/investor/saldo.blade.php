@extends('layouts.app')

@section('title', 'Saldo Investor')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-wallet2 me-2"></i>Dashboard Saldo</h2>

    <div class="row g-4">
        {{-- Card Ringkasan Saldo --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Saldo Tersedia</h5>
                    <h3 class="text-success">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    <p class="text-muted">Saldo dapat digunakan untuk mendanai UMKM, atau ditarik kembali sesuai kebijakan platform.</p>
                    <a href="{{ route('investor.transaksi') }}" class="btn btn-success mt-2">Donasi</a>
                </div>
            </div>
        </div>

        {{-- Card Top Up Saldo --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Top Up Saldo</h5>
                    <form action="{{ route('investor.transaksi') }}" method="get">
                        <div class="mb-3">
                            <label for="donasi-amount" class="form-label">Nominal Donasi</label>
                            <input type="number" class="form-control" id="donasi-amount" name="jumlah" placeholder="Masukkan nominal" min="10000">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Top Up</button>
                    </form>
                    <div class="text-muted small mt-2">*Donasi akan diproses melalui halaman transaksi.</div>
                </div>
            </div>
        </div>

        {{-- Info Tambahan --}}
        <div class="col-12">
            <div class="alert alert-info mt-3">
                <strong>Catatan:</strong> Semua transaksi disimpan dan dapat diakses pada halaman <a href="{{ route('investor.transaksi') }}">riwayat transaksi</a>. Saldo bersifat fleksibel dan dapat digunakan untuk berbagai aktivitas pendanaan UMKM.
            </div>
        </div>
    </div>
</div>
@endsection
