@extends('layouts.app')

@section('title', 'Dashboard Investor')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2 text-gradient-premium" style="font-size:2.3rem; letter-spacing:1px;">
            Dashboard Investor
        </h2>
        <p class="lead text-premium-dark mb-3 animate__animated animate__fadeInDown" style="font-size:1.15rem;">
            Temukan UMKM terbaik, kelola portofolio, dan nikmati pengalaman investasi <span class="fw-bold text-gradient-premium"></span> di Basiru.
        </p>
    </div>

    <div class="mb-4 animate__animated animate__fadeInDown">
        <div class="alert alert-success d-flex align-items-center gap-2 shadow-sm mb-3" style="font-size:1.1rem;">
            <i class="bi bi-stars fs-3 text-warning"></i>
            <div>
                <strong>Selamat datang di Dashboard Investor Basiru!</strong> Kini kamu bisa mendukung UMKM lokal, memantau portofolio, dan berinvestasi dengan mudah. Raih peluang terbaik dan jadilah bagian dari perubahan ekonomi Indonesia!
            </div>
        </div>
        @if(isset($portofolio) && !$portofolio)
            <div class="alert alert-warning d-flex align-items-center gap-2 shadow-sm mb-3 animate__animated animate__fadeInDown">
                <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
                <div>
                    <strong>Lengkapi data diri Anda!</strong> Silakan lengkapi data diri di <a href="{{ url('/portofolio') }}" class="alert-link">Portofolio</a> agar bisa melakukan transaksi investasi.
                </div>
            </div>
        @endif
    </div>

    <div class="row g-4 animate__animated animate__fadeInUp animate__delay-2s">
        @forelse ($umkms as $umkm)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-lg h-100 rounded-4 bg-gradient-card position-relative animate__animated animate__zoomIn card-hover-premium">
                    @if ($umkm->foto)
                        <img src="{{ asset('storage/' . $umkm->foto) }}" class="card-img-top rounded-top-4" alt="{{ $umkm->nama }}" style="height: 180px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x180?text=UMKM" class="card-img-top rounded-top-4" alt="UMKM">
                    @endif
                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-2">
                        @if (now()->diffInDays($umkm->created_at) <= 7)
                            <span class="badge bg-gradient-premium shadow-sm animate__animated animate__bounceIn">Baru</span>
                        @endif
                        @if (($umkm->jumlah_investor ?? 0) > 0)
                            <span class="badge bg-info shadow-sm animate__animated animate__fadeInDown">{{ $umkm->jumlah_investor }} Investor</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-gradient-premium mb-1">{{ $umkm->nama }}</h5>
                        <p class="card-text text-premium-dark mb-2">{{ \Illuminate\Support\Str::limit($umkm->deskripsi, 80) }}</p>
                        <div class="d-flex justify-content-between mb-2 flex-wrap gap-1">
                            <span class="badge bg-gradient-premium fs-6" style="font-size:0.85rem; min-width:120px;">Dana Dibutuhkan: <span class="fw-bold">Rp {{ number_format($umkm->dana_dibutuhkan, 0, ',', '.') }}</span></span>
                            <span class="badge bg-gradient-premium2 fs-6" style="font-size:0.95rem; min-width:110px;">Terkumpul: <span class="fw-bold">Rp {{ number_format($umkm->dana_terkumpul, 0, ',', '.') }}</span></span>
                        </div>
                        @if ($umkm->dana_terkumpul >= $umkm->dana_dibutuhkan)
                            <div class="alert alert-success p-2 text-center fw-semibold rounded-3 mb-2 animate__animated animate__pulse animate__infinite">
                                🎉 Dana Tercapai!
                            </div>
                        @else
                            <div class="alert alert-warning p-2 text-center rounded-3 fw-medium mb-2 animate__animated animate__pulse animate__infinite">
                                💰 Masih Butuh Dukungan
                            </div>
                        @endif
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('investor.transaksi', ['umkm_id' => $umkm->id]) }}" class="btn btn-gradient-premium2 rounded-pill fw-bold shadow-sm flex-fill animate__animated animate__fadeInUp">Investasi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted animate__animated animate__fadeIn">
                <p>Belum ada UMKM yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

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
    color: #fff;
}
.bg-gradient-premium2 {
    background: linear-gradient(135deg, #283e51 0%, #485563 100%);
    color: #fff;
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
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.btn-outline-premium:hover {
    background: linear-gradient(90deg, #7b4397 0%, #dc2430 100%);
    color: #fff;
    box-shadow: 0 4px 16px 0 #dc243055;
}
.card-hover-premium {
    transition: transform 0.25s, box-shadow 0.25s;
}
.card-hover-premium:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 8px 32px 0 #7b439755;
    z-index: 2;
}
.text-premium-dark {
    color: #283e51;
}
</style>
@endpush
@endsection
