@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #007bff 0%, #00c6ff 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .btn-primary {
        background-color: #0066ff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #004ccc;
    }

    .logo-title {
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .description-text {
        color: white;
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .small-close {
    transform: scale(0.7);
    margin-top: -2px;
}
</style>

<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100 align-items-center">
        <div class="col-lg-6 text-center text-lg-start px-5 mb-5 mb-lg-0">
            <h1 class="logo-title">Selamat Datang di <span class="text-warning">Basiru</span></h1>
            <p class="description-text mt-3">
                Platform Crowdfunding untuk mendukung UMKM Kabupaten Sumbawa secara digital dan transparan.
                Mari berkontribusi bersama!
            </p>
        </div>

        <div class="col-lg-5 d-flex justify-content-center">
            <div class="card glass-card p-4 shadow-lg w-100" style="max-width: 420px;">
                {{-- Alert Error --}}
                @error('email')
                    <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 py-2" role="alert" style="font-size: 0.9rem;">
                        <strong>Login Gagal!</strong> {{ $message }}
                        <button type="button" class="btn-close small-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                <h4 class="text-center text-white mb-4 fw-bold">Masuk Akun Anda</h4>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-white">Alamat Email</label>
                        <input type="email" name="email" class="form-control rounded-pill" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-white">Kata Sandi</label>
                        <input type="password" name="password" class="form-control rounded-pill" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary rounded-pill fw-semibold">Masuk</button>
                    </div>
                    <div class="text-center text-white">
                        <small>Belum punya akun? 
                            <a href="{{ url('/register') }}" class="text-white text-decoration-underline fw-semibold">
                                Daftar Sekarang
                            </a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection