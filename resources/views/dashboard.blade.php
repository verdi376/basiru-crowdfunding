@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-center mb-2">
        Selamat Datang, {{ Auth::user()->name }} 👋
    </h2>
    <p class="text-center text-muted mb-4">
        Ini adalah halaman utama <strong>Basiru</strong> — Platform Crowdfunding untuk mendukung UMKM Lokal Berbasis Semangat Gotong Royong.
    </p>

    <div class="row">
        @forelse ($umkms as $umkm)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100 rounded-4">
                    @if ($umkm->foto)
                        <img src="{{ asset('storage/' . $umkm->foto) }}" class="card-img-top rounded-top-4" alt="{{ $umkm->nama }}" style="height: 180px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x180?text=UMKM" class="card-img-top rounded-top-4" alt="UMKM">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary">{{ $umkm->nama }}</h5>
                        <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($umkm->deskripsi, 100) }}</p>

                        <div class="mt-2">
                            <p class="mb-1">
                                <i class="bi bi-wallet2 text-success"></i> 
                                <strong>Dana Dibutuhkan:</strong> Rp {{ number_format($umkm->dana_dibutuhkan, 0, ',', '.') }}
                            </p>
                            <p class="mb-2">
                                <i class="bi bi-piggy-bank text-warning"></i>
                                <strong>Dana Terkumpul:</strong> Rp {{ number_format($umkm->dana_terkumpul, 0, ',', '.') }}
                            </p>

                            @if ($umkm->dana_terkumpul >= $umkm->dana_dibutuhkan)
                                <div class="alert alert-success p-2 text-center fw-semibold rounded-3 mb-2">
                                    🎉 Dana Tercapai!
                                </div>
                            @else
                                <div class="alert alert-warning p-2 text-center rounded-3 fw-medium mb-2">
                                    💰 Masih Butuh Dukungan
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('investor.transaksi', ['umkm_id' => $umkm->id]) }}" class="btn btn-primary rounded-pill mt-2"> Bantu Sekarang
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                <p>Belum ada UMKM yang bergabung.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
