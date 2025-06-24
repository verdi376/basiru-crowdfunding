@extends('layouts.app')

@section('title', 'Tentang Basiru')

@section('content')
<div class="container my-5">

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">
            <i class="bi bi-people-fill me-2"></i> Tentang <span class="text-primary">Basiru</span>
        </h2>
        <p class="text-muted fs-5">
            Platform Crowdfunding berbasis gotong royong untuk mendukung pertumbuhan UMKM lokal di Sumbawa.
        </p>
    </div>

    {{-- Misi & Visi --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                <h5 class="fw-semibold">
                    <i class="bi bi-bullseye text-primary me-2"></i> Misi Kami
                </h5>
                <p class="mb-0">
                    Membantu UMKM lokal berkembang melalui sistem pendanaan berbasis komunitas yang aman, transparan, dan menjunjung nilai gotong royong.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                <h5 class="fw-semibold">
                    <i class="bi bi-eye-fill text-primary me-2"></i> Visi Kami
                </h5>
                <p class="mb-0">
                    Menjadi platform crowdfunding berbasis kearifan lokal terbesar di Indonesia yang memperkuat ekonomi rakyat melalui kolaborasi.
                </p>
            </div>
        </div>
    </div>

    {{-- Apa yang Kami Tawarkan --}}
    <div class="mb-5">
        <div class="p-4 bg-white rounded-3 shadow-sm">
            <h5 class="fw-semibold mb-3">
                <i class="bi bi-gift-fill text-primary me-2"></i> Apa yang Kami Tawarkan?
            </h5>
            <ul class="mb-0">
                <li>Pendanaan mikro dan makro berbasis komunitas</li>
                <li>Transparansi transaksi dan laporan real-time</li>
                <li>Dukungan pembinaan & pelatihan untuk UMKM</li>
                <li>Peluang investasi sosial untuk masyarakat umum</li>
            </ul>
        </div>
    </div>
</div>

<footer class="bg-primary text-white py-4" style="width: 100vw; margin-left: calc(-50vw + 50%);">
    <div class="container px-4">
        <div class="row justify-content-center text-start">
            
            {{-- Kolom Alamat --}}
            <div class="col-12 col-md-5 mb-4 mb-md-0">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-geo-alt-fill me-2"></i>Alamat:
                </h6>
                <p class="mb-0 small">
                    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raya+Olat+Maras,+Moyo+Hulu,+Kab.+Sumbawa,+NTB+84371"
                       target="_blank"
                       class="text-white text-decoration-underline">
                        Jl. Raya Olat Maras, Moyo Hulu, Kab. Sumbawa,<br>
                        Nusa Tenggara Barat 84371
                    </a>
                </p>
            </div>

            {{-- Kolom Kontak (Digeser ke kanan) --}}
            <div class="col-12 col-md-5 ms-md-5">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-headset me-2"></i>Layanan Kontak:
                </h6>
                <p class="mb-1 small">
                    <i class="bi bi-whatsapp me-2"></i>
                    <a href="https://wa.me/6282182280191" target="_blank" class="text-white text-decoration-underline">
                        0821-8228-0191
                    </a>
                </p>
                <p class="mb-0 small">
                    <i class="bi bi-envelope-fill me-2"></i>
                    <a href="mailto:CostumerBasiru@gmail.com" class="text-white text-decoration-underline">
                        CostumerBasiru@gmail.com
                    </a>
                </p>
            </div>

        </div>
    </div>
</footer>

@endsection