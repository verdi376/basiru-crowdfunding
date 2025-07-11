{{-- resources/views/umkm/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container py-4 animate__animated animate__fadeIn">
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1 text-gradient-premium" style="font-size:2.1rem; letter-spacing:1px;">
            Selamat Datang di Dashboard UMKM, <span class="text-gradient-premium">{{ $user->name }}</span>! 🚀
        </h2>
        <p class="lead text-premium-dark mb-2" style="font-size:1.1rem;">
            <span class="fw-semibold">Bangun usahamu lebih maju bersama <span class="text-gradient-premium">Basiru</span>!</span><br>
            <span class="fw-bold text-premium">Kelola profil, pantau perkembangan, dan raih dukungan dari para investor inspiratif.<br>Jangan ragu untuk terus berinovasi dan promosikan UMKM-mu!</span>
        </p>
    </div>

    @if ($umkm)
        <div class="card shadow-lg border-0 rounded-4 bg-gradient-card p-4 animate__animated animate__fadeInUp">
            <h5 class="fw-bold text-gradient-premium mb-2" style="font-size:1.3rem;">{{ $umkm->nama }}</h5>
            <p class="text-premium-dark mb-3">{{ $umkm->deskripsi }}</p>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="p-3 rounded-3 bg-gradient-premium text-white text-center mb-2">
                        <div class="fw-bold" style="font-size:1.1rem;">Dana Dibutuhkan</div>
                        <div class="fs-5">Rp {{ number_format($umkm->dana_dibutuhkan, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded-3 bg-gradient-premium2 text-white text-center mb-2">
                        <div class="fw-bold" style="font-size:1.1rem;">Dana Terkumpul</div>
                        <div class="fs-5">Rp {{ number_format($umkm->dana_terkumpul, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @if ($umkm->dana_terkumpul >= $umkm->dana_dibutuhkan)
                <div class="alert alert-success text-center fw-semibold rounded-3 animate__animated animate__pulse animate__infinite">
                    🎉 Selamat! Dana UMKM-mu sudah tercapai. Terus pertahankan prestasi ini!
                </div>
            @else
                <div class="alert alert-warning text-center rounded-3 fw-medium animate__animated animate__pulse animate__infinite">
                    💰 Masih butuh dukungan investor. Promosikan usahamu dan raih lebih banyak peluang!
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-warning mt-4 animate__animated animate__fadeIn">
            Kamu belum memiliki data UMKM. <a href="{{ route('umkm.create') }}" class="fw-bold text-gradient-premium">Tambahkan sekarang</a>.
        </div>
    @endif
</div>

@section('submenu')
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('umkm.dashboard') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.dashboard') ? 'active text-white fw-bold' : 'text-white-50' }}">Home</a>
        <a href="{{ route('umkm.profil') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.profil') ? 'active text-white fw-bold' : 'text-white-50' }}">Profil UMKM</a>
        <a href="{{ route('umkm.laporan.index') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.laporan.index') ? 'active text-white fw-bold' : 'text-white-50' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Laporan Penjualan
        </a>
        <a href="{{ route('umkm.saldo') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.saldo') ? 'active text-white fw-bold' : 'text-white-50' }}">Saldo</a>
        <a href="{{ route('umkm.transaksi') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.transaksi') ? 'active text-white fw-bold' : 'text-white-50' }}">Transaksi</a>
    </div>
@endsection

@push('scripts')
<style>
.text-gradient-premium {
    background: linear-gradient(90deg, #7b4397 0%, #dc2430 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
}
.bg-gradient-premium {
    background: linear-gradient(135deg, #7b4397 0%, #dc2430 100%);
}
.bg-gradient-premium2 {
    background: linear-gradient(135deg, #283e51 0%, #485563 100%);
}
.bg-gradient-card {
    background: linear-gradient(135deg, #f8fafc 60%, #e0e7ef 100%);
}
.btn-gradient-premium {
    background: linear-gradient(90deg, #7b4397 0%, #dc2430 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.btn-gradient-premium:hover {
    box-shadow: 0 4px 16px 0 #dc243055;
    transform: translateY(-2px) scale(1.04);
    color: #fff;
}
.btn-gradient-premium2 {
    background: linear-gradient(90deg, #283e51 0%, #485563 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.btn-gradient-premium2:hover {
    box-shadow: 0 4px 16px 0 #48556355;
    transform: translateY(-2px) scale(1.04);
    color: #fff;
}
.btn-outline-premium {
    border: 2px solid #7b4397;
    color: #7b4397;
    background: #fff;
    transition: background 0.2s, color 0.2s;
}
.btn-outline-premium:hover {
    background: #7b4397;
    color: #fff;
}
.btn-outline-premium2 {
    border: 2px solid #283e51;
    color: #283e51;
    background: #fff;
    transition: background 0.2s, color 0.2s;
}
.btn-outline-premium2:hover {
    background: #283e51;
    color: #fff;
}
.text-premium-dark {
    color: #283e51;
}
</style>
@endpush
@endsection
