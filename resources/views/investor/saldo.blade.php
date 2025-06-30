@extends('layouts.app')

@section('title', 'Saldo Investor')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-wallet2 me-2"></i>Dashboard Saldo</h2>

    {{-- Tampilkan Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

        {{-- Card Top Up & Tarik Saldo --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kelola Saldo</h5>
                    <form action="{{ route('investor.topup') }}" method="POST" class="mb-3">
                        @csrf
                        <label for="topup-amount" class="form-label">Nominal Top Up</label>
                        <input type="number" class="form-control mb-2" id="topup-amount" name="jumlah" placeholder="Masukkan nominal" min="10000">
                        <button type="submit" class="btn btn-primary w-100">Top Up</button>
                    </form>

                    <form action="{{ route('investor.tarik') }}" method="POST" onsubmit="return confirm('Yakin ingin menarik saldo?')">
                        @csrf
                        <label for="tarik-amount" class="form-label">Nominal Tarik</label>
                        <input type="number" class="form-control mb-2" id="tarik-amount" name="jumlah" placeholder="Masukkan nominal" min="10000" max="{{ $saldo }}">
                        <button type="submit" class="btn btn-danger w-100">Tarik Saldo</button>
                    </form>

                    <div class="text-muted small mt-2">*Top Up dan Tarik Saldo akan langsung berdampak ke saldo utama Anda.</div>
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
