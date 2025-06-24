@extends('layouts.app')

@section('title', 'Register')

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

    .btn-success {
        background-color: #00a96d;
        border: none;
    }

    .btn-success:hover {
        background-color: #008d5c;
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
</style>

<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row w-100 align-items-center">
        <div class="col-lg-6 text-center text-lg-start px-5 mb-5 mb-lg-0">
            <h1 class="logo-title">Gabung bersama Basiru</h1>
            <p class="description-text mt-3">Dukung UMKM Sumbawa tumbuh dan berkembang melalui platform crowdfunding yang aman dan terpercaya.</p>
        </div>
        <div class="col-lg-5 d-flex justify-content-center">
            <div class="card glass-card p-4 shadow-lg w-100" style="max-width: 480px;">
                <h4 class="text-center text-white mb-4 fw-bold">Buat Akun Baru</h4>
                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-white">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Kata Sandi</label>
                        <input type="password" name="password" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-white">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success rounded-pill fw-semibold">Daftar</button>
                    </div>
                    <div class="text-center text-white">
                        <small>Sudah punya akun? <a href="{{ url('/login') }}" class="text-white text-decoration-underline fw-semibold">Masuk</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection