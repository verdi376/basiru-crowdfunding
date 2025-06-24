<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Basiru')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Basiru</a>

        @if (request()->routeIs('dashboard'))
        <form class="d-flex ms-auto" role="search" method="GET" action="{{ route('dashboard') }}" style="width: 600px; margin-left: 20rem !important; margin-right: 10rem;">
            <input class="form-control me-2" type="search" name="q" placeholder="Cari UMKM..." aria-label="Search" value="{{ request('q') }}">
            <button class="btn btn-light" type="submit">🔍</button>
        </form>
        @endif


        {{-- Hamburger Button for Mobile --}}
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Desktop Menu --}}
        <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end">
            <ul class="navbar-nav align-items-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Beranda</a>
                    </li>

                    {{-- Investor Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="investorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Investor
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="investorDropdown">
                            <li><a class="dropdown-item" href="{{ route('investor.saldo') }}">Saldo</a></li>
                            <li><a class="dropdown-item" href="{{ route('investor.transaksi') }}">Transaksi</a></li>
                        </ul>
                    </li>

                    {{-- UMKM Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="umkmDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            UMKM
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="umkmDropdown">
                            <li><a class="dropdown-item" href="{{ route('umkm.profil') }}">Profil UMKM</a></li>
                            <li><a class="dropdown-item" href="{{ route('umkm.saldo') }}">Saldo UMKM</a></li>
                        </ul>
                    </li>

                    {{-- Profile Menu --}}
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="rounded-circle" width="36" height="36" alt="avatar">
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

{{-- MOBILE MENU (OFFCANVAS) --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            @auth
                {{-- Menu Utama --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Beranda</a>
                </li>

                {{-- Investor (Dropdown-like) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#mobileInvestor" role="button" aria-expanded="false" aria-controls="mobileInvestor">
                        Investor
                    </a>
                    <div class="collapse" id="mobileInvestor">
                        <ul class="list-unstyled ms-3">
                            <li><a class="nav-link" href="{{ route('investor.saldo') }}">Saldo</a></li>
                            <li><a class="nav-link" href="{{ route('investor.transaksi') }}">Transaksi</a></li>
                        </ul>
                    </div>
                </li>

                {{-- UMKM (Dropdown-like) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#mobileUmkm" role="button" aria-expanded="false" aria-controls="mobileUmkm">
                        UMKM
                    </a>
                    <div class="collapse" id="mobileUmkm">
                        <ul class="list-unstyled ms-3">
                            <li><a class="nav-link" href="{{ route('umkm.profil') }}">Profil UMKM</a></li>
                            <li><a class="nav-link" href="{{ route('umkm.saldo') }}">Saldo UMKM</a></li>
                        </ul>
                    </div>
                </li>

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
<div class="container mt-4">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
