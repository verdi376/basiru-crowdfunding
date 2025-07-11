<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Basiru')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @yield('head')
</head>
<body class="bg-light">

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        💸 {{ session('error') }}
        <a href="{{ route('investor.saldo') }}" class="alert-link">Top-up di sini</a>.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary position-fixed w-100 top-0 shadow-lg" style="z-index: 1050;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Basiru</a>

        {{-- Search hanya di dashboard utama investor --}}
        @if (request()->routeIs('investor.dashboard'))
            <form class="d-flex ms-auto" role="search" method="GET" action="{{ route('investor.dashboard') }}"
                  style="width: 400px; margin-left: 10rem !important; margin-right: 5rem;">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari UMKM..." value="{{ request('q') }}">
                <button class="btn btn-light" type="submit">🔍</button>
            </form>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end">
            <ul class="navbar-nav align-items-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if (request()->is('umkm*'))
                        <li class="nav-item ms-2">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('umkm.dashboard') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.dashboard') ? 'active text-white fw-bold' : 'text-white-50' }}">Home</a>
                                <a href="{{ route('umkm.profil') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.profil') ? 'active text-white fw-bold' : 'text-white-50' }}">Profil UMKM</a>
                                <a href="{{ route('umkm.saldo') }}" class="nav-link px-3 rounded-pill premium-umkm-link {{ request()->routeIs('umkm.saldo') ? 'active text-white fw-bold' : 'text-white-50' }}">Saldo</a>
  

                            </div>
                        </li>
                    @endif
                    @if (request()->is('investor*'))
                        <li class="nav-item ms-2">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('investor.dashboard') }}" class="nav-link px-3 rounded-pill premium-investor-link {{ request()->routeIs('investor.dashboard') ? 'active text-white fw-bold' : 'text-white-50' }}">Home</a>
                                <a href="{{ route('portofolios.index') }}" class="nav-link px-3 rounded-pill premium-investor-link {{ request()->routeIs('portofolios.index') ? 'active text-white fw-bold' : 'text-white-50' }}">Portofolio</a>
                                <div class="nav-item dropdown">
                                    <a class="nav-link px-3 rounded-pill premium-investor-link dropdown-toggle {{ (request()->routeIs('investor.saldo') || request()->routeIs('investor.transaksi')) ? 'active text-white fw-bold' : 'text-white-50' }}" href="#" id="saldoTransaksiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Saldo & Transaksi
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="saldoTransaksiDropdown">
                                        <li><a class="dropdown-item" href="{{ route('investor.saldo') }}">Saldo</a></li>
                                        <li><a class="dropdown-item" href="{{ route('investor.transaksi') }}">Transaksi</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if (!request()->is('investor*') && !request()->is('umkm*') && (!Auth::user() || Auth::user()->role !== 'admin'))
                        {{-- Menu utama sebelum masuk investor/UMKM, tapi bukan admin --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('investor.dashboard') }}">Investor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('umkm.dashboard') }}">UMKM</a>
                        </li>
                    @endif

                    {{-- Profil --}}
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                 class="rounded-circle" width="36" height="36" alt="avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profil.akun') }}">Profil Akun</a></li>
                            <li><a class="dropdown-item" href="{{ route('tentang') }}">Tentang</a></li>
                            <li><a class="dropdown-item" href="{{ route('bantuan') }}">Bantuan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- MOBILE MENU --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            @auth
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>

                @if (!request()->is('investor*') && !request()->is('umkm*'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('investor.dashboard') }}">Investor</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('umkm.dashboard') }}">UMKM</a></li>
                @endif

                <hr class="my-3">
                <h6 class="text-muted px-2">Akun</h6>
                <li class="nav-item"><a class="nav-link" href="{{ route('profil.akun') }}">Profil Akun</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tentang') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bantuan') }}">Bantuan</a></li>
                <li class="nav-item mt-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger w-100" type="submit">Keluar</button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
            @endauth
        </ul>
    </div>
</div>

{{-- CONTENT --}}
<div class="container mt-4" style="padding-top: 90px;">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
@push('scripts')
<style>
.premium-umkm-link {
    background: linear-gradient(90deg, #7b4397 0%, #dc2430 100%);
    color: #fff !important;
    font-weight: 500;
    box-shadow: 0 2px 8px 0 #dc243033;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
    border: none;
    margin-bottom: 0 !important;
}
.premium-umkm-link:hover, .premium-umkm-link.active {
    background: linear-gradient(90deg, #dc2430 0%, #7b4397 100%);
    color: #fff !important;
    box-shadow: 0 4px 16px 0 #7b439755;
    transform: translateY(-2px) scale(1.04);
    text-decoration: none;
}
.premium-investor-link {
    background: linear-gradient(90deg, #283e51 0%, #485563 100%);
    color: #fff !important;
    font-weight: 500;
    box-shadow: 0 2px 8px 0 #48556333;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
    border: none;
    margin-bottom: 0 !important;
}
.premium-investor-link:hover, .premium-investor-link.active {
    background: linear-gradient(90deg, #485563 0%, #283e51 100%);
    color: #fff !important;
    box-shadow: 0 4px 16px 0 #283e5155;
    transform: translateY(-2px) scale(1.04);
    text-decoration: none;
}
</style>
@endpush
</body>
</html>
