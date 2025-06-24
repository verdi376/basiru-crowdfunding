@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-center mb-2">
        Selamat Datang, {{ Auth::user()->name }} 👋
    </h2>
    <p class="text-center text-muted mb-4">
        Ini adalah halaman utama Aplikasi Basiru — Platform Crowdfunding untuk mendukung UMKM Lokal Berbasis Semangat Gotong Royong.
    </p>

    <div class="row">
        @forelse ($umkms as $umkm)
            <div class="col-6 col-md-4 mb-4">
                <div class="card umkm-card h-100">
                    @if ($umkm->foto)
                        <img src="{{ asset('storage/' . $umkm->foto) }}" class="card-img-top" alt="{{ $umkm->nama }}" style="height: 180px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x180?text=UMKM" class="card-img-top" alt="UMKM">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $umkm->nama }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ $umkm->deskripsi }}</p>
                        <a href="{{ route('investor.transaksi') }}" class="btn btn-primary rounded-pill mt-2">
                            Bantu Sekarang
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
