@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-blue-50 py-12 px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg animate-fade-in">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Instruksi Pembayaran</h2>
            <p class="text-gray-600 mb-4">Gunakan metode di bawah untuk menyelesaikan top up sebesar:</p>
            <h3 class="text-3xl text-blue-600 font-extrabold mb-6">Rp {{ number_format($nominal, 0, ',', '.') }}</h3>
        </div>

        <div class="text-center mb-6">
            @php
                $icons = [
                    'dana' => 'https://upload.wikimedia.org/wikipedia/commons/f/f8/Dana_logo.svg',
                    'gopay' => 'https://gopay.co.id/icon.png',
                    'ovo' => 'https://upload.wikimedia.org/wikipedia/commons/0/00/Ovo_logo.svg',
                    'bca' => 'https://seeklogo.com/images/B/bca-bank-central-asia-logo-8ED401F46E-seeklogo.com.png',
                    'bri' => 'https://upload.wikimedia.org/wikipedia/commons/d/d7/Logo_Bank_BRI.svg',
                    'mbanking' => 'https://img.icons8.com/fluency/48/bank-card-back-side.png',
                ];
                $metodeName = strtoupper($metode);
            @endphp

            {{-- <img src="{{ $icons[$metode] ?? 'https://img.icons8.com/ios-filled/50/000000/money.png' }}" class="h-16 mx-auto mb-2" alt="{{ $metodeName }}">
            <p class="text-lg font-semibold text-gray-400">{{ $metodeName }}</p>
        </div> --}}
        @if (!empty($qrImagePath))
            <div class="flex justify-center items-center mb-3 animate__animated animate__fadeInUp">
                <img src="{{ $qrImagePath }}" alt="QR Code {{ $metode }}" class="w-56 h-56 border-2 border-[#b39ddb] rounded-2xl shadow-lg bg-white object-contain mx-auto">
            </div>
            <p class="text-center text-[#616161] text-base font-medium mb-2">Scan QR di atas melalui aplikasi <span class="font-bold text-[#283593]">{{ ucfirst($metode) }}</span> Anda.</p>
        @elseif (!empty($qrText))
            <div class="text-center bg-gray-100 rounded-xl py-4 px-6 mb-4 text-xl font-mono font-semibold tracking-wider">
                {{ $qrText }}
            </div>
            <p class="text-center text-gray-500 text-sm">Salin nomor Virtual Account dan bayarkan melalui aplikasi {{ ucfirst($metode) }} atau ATM.</p>
        @endif


        <div class="mt-8 text-center">
            <a href="{{ route('investor.saldo') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow-md">
                Kembali ke Saldo
            </a>
        </div>
    </div>
</div>
@endsection
