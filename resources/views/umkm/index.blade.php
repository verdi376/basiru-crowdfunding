@extends('layouts.app')

@section('title', 'UMKM Saya')

@section('content')
<div class="container py-5">

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Jika user sudah punya profil UMKM --}}
    @if($umkm)
        <div class="card shadow-lg border-0 animate__animated animate__fadeIn">
            <div class="row g-0">
                {{-- Foto UMKM --}}
                @if($umkm->foto)
                    <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
                        <img src="{{ asset('storage/' . $umkm->foto) }}" alt="Foto UMKM" class="img-fluid rounded shadow" style="max-height: 250px;">
                    </div>
                @endif

                {{-- Informasi UMKM --}}
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title text-primary fw-bold">{{ $umkm->nama }}</h2>
                        <p class="mb-2"><i class="bi bi-tags"></i> <strong>Kategori:</strong> {{ $umkm->kategori }}</p>
                        <p class="mb-2"><i class="bi bi-geo-alt"></i> <strong>Lokasi:</strong> {{ $umkm->lokasi }}</p>
                        <p class="mb-2"><i class="bi bi-telephone"></i> <strong>Kontak:</strong> {{ $umkm->kontak }}</p>
                        <p class="text-muted mt-3">{{ $umkm->deskripsi }}</p>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('umkm.edit') }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Edit Profil
                            </a>
                            <a href="{{ route('umkm.saldo') }}" class="btn btn-outline-success">
                                <i class="bi bi-wallet2"></i> Lihat Saldo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Jika user belum membuat profil UMKM --}}
    @else
        <div class="text-center py-5 animate__animated animate__fadeInUp">
            <img src="https://cdn-icons-png.flaticon.com/512/4333/4333609.png" alt="Belum Ada UMKM" width="150" class="mb-4">
            <h2 class="text-danger fw-bold">Belum Ada UMKM</h2>
            <p class="text-muted">Buat profil UMKM kamu dan mulai tampilkan usahamu kepada para investor dan donatur.</p>
            <a href="{{ route('umkm.create') }}" class="btn btn-lg btn-primary mt-3 animate__animated animate__pulse animate__infinite">
                <i class="bi bi-plus-circle"></i> Buat Profil UMKM Sekarang
            </a>
        </div>
    @endif

</div>
@endsection
