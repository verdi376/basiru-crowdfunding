@extends('layouts.app')

@section('title', 'Pilih Metode Pembayaran')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .payment-option {
        border: 2px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 12px;
    }
    .payment-option:hover {
        transform: scale(1.02);
        border-color: #0d6efd;
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.3);
        background-color: #f8f9fa;
    }
    .payment-option input:checked + label {
        background-color: #e7f1ff;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        font-weight: bold;
    }
    .payment-logo {
        height: 32px;
        width: 48px;
        object-fit: contain;
        margin-right: 12px;
        background: #fff;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 1px 4px #e0e0e033;
    }
    .form-check-input {
        transform: scale(1.2);
        margin-top: 0;
    }

    /* 🐱 Background Kucing */
    body {
        background-image: url('/img/cat-bg.png');
        background-repeat: no-repeat;
        background-position: bottom right;
        background-size: 160px;
        background-attachment: fixed;
    }

    /* ✨ Sparkle hover effect */
    .btn-primary:hover::after {
        content: '';
        position: absolute;
        top: -20%;
        left: -20%;
        width: 140%;
        height: 140%;
        background: radial-gradient(circle, rgba(255,255,255,0.5) 0%, transparent 60%);
        animation: sparkle 0.6s ease-in-out;
        border-radius: 50%;
        z-index: 0;
    }

    @keyframes sparkle {
        from {
            opacity: 1;
            transform: scale(0.5);
        }
        to {
            opacity: 0;
            transform: scale(2.5);
        }
    }

    .btn-primary {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
</style>

<div class="container py-5 animate__animated animate__fadeInUp">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/891/891419.png" width="80" alt="Wallet Icon" class="mb-3 animate__animated animate__bounceIn">
        <h2 class="fw-bold">Pilih Metode Pembayaran</h2>
        <p class="text-muted">Nominal: <strong class="text-success">Rp {{ number_format($nominal, 0, ',', '.') }}</strong></p>
    </div>

    <form method="POST" action="{{ route('investor.topup.process') }}" class="row justify-content-center">
        @csrf
        <input type="hidden" name="nominal" value="{{ $nominal }}">
        <input type="hidden" name="konfirmasi" value="qr">
        <div class="col-md-6">

            @php
                $metodes = [
                    ['id' => 'dana', 'label' => 'DANA', 'img' => asset('assets/img/payment/dana.png')],
                    ['id' => 'gopay', 'label' => 'GoPay', 'img' => asset('assets/img/payment/gopay.png')],
                    ['id' => 'ovo', 'label' => 'OVO', 'img' => asset('assets/img/payment/ovo.png')],
                    ['id' => 'bca', 'label' => 'BCA (VA)', 'img' => asset('assets/img/payment/bca.png')],
                    ['id' => 'bri', 'label' => 'BRI (VA)', 'img' => asset('assets/img/payment/bri.png')],
                    ['id' => 'bni', 'label' => 'BNI (VA)', 'img' => asset('assets/img/payment/bni.png')],
                ];
            @endphp

            @foreach ($metodes as $metode)
            <div class="card mb-3 shadow-sm payment-option">
                <div class="card-body d-flex align-items-center">
                    <input class="form-check-input me-3" type="radio" name="metode" value="{{ $metode['id'] }}" id="{{ $metode['id'] }}" required hidden>
                    <label class="form-check-label d-flex align-items-center w-100" for="{{ $metode['id'] }}">
                        <img src="{{ $metode['img'] }}" alt="{{ $metode['label'] }}" class="payment-logo">
                        <span class="fs-6">{{ $metode['label'] }}</span>
                    </label>
                </div>
            </div>
            @endforeach

            {{-- Tambahkan pilihan konfirmasi --}}
            <div class="mt-4">
                <label class="form-label fw-semibold">Pilih Konfirmasi Pembayaran</label>
                <select name="konfirmasi" class="form-select" required>
                    <option value="qr">QR Code (Scan)</option>
                    <option value="va">Virtual Account (Salin Kode)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 animate__animated animate__pulse animate__infinite">
                <i class="bi bi-cash-coin me-1"></i> Bayar Sekarang
            </button>
        </div>
    </form>
</div>

{{-- 🎵 Sound click --}}
<audio id="click-sound" src="{{ asset('sounds/click.mp3') }}"></audio>
<script>
    document.querySelectorAll('button, a').forEach(el => {
        el.addEventListener('click', () => {
            const audio = document.getElementById('click-sound');
            if (audio) {
                audio.currentTime = 0;
                audio.play();
            }
        });
    });
</script>
@endsection
