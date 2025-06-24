@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Profil Akun</h3>

    {{-- Informasi Akun --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Informasi Pribadi</h5>
            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (tidak dapat diubah)</label>
                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                </div>

                <button type="submit" class="btn btn-success rounded-pill">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Ubah Password --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
                <span>Ubah Password</span>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#passwordCollapse">
                    🔒 Tampilkan Form
                </button>
            </h5>

            <div class="collapse mt-3" id="passwordCollapse">
                <form action="{{ route('profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill">Perbarui Password</button>
                </form>
            </div>
        </div>
    </div>

    {{-- UMKM yang dimiliki --}}
    @if (Auth::user()->umkm)
    <div class="mt-5">
        <h4 class="fw-bold">UMKM Anda</h4>
        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . Auth::user()->umkm->foto) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ Auth::user()->umkm->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ Auth::user()->umkm->nama }}</h5>
                        <p class="card-text text-muted">{{ Auth::user()->umkm->kategori }} - {{ Auth::user()->umkm->lokasi }}</p>
                        <a href="{{ route('umkm.profil') }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
