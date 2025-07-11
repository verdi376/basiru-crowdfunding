@extends('layouts.app')

@section('title', 'Data Portofolio')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-4 mb-4">
            @if(isset($portofolio) && $portofolio)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Data Diri</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><strong>Nama:</strong> {{ $portofolio->nama_lengkap }}</li>
                            <li class="list-group-item"><strong>TTL:</strong> {{ $portofolio->tempat_lahir }}, {{ \Carbon\Carbon::parse($portofolio->tanggal_lahir)->format('d M Y') }}</li>
                            <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $portofolio->jenis_kelamin }}</li>
                            <li class="list-group-item"><strong>No Telepon:</strong> {{ $portofolio->no_telepon }}</li>
                            <li class="list-group-item"><strong>Alamat:</strong> {{ $portofolio->alamat }}</li>
                            <li class="list-group-item"><strong>Pekerjaan:</strong> {{ $portofolio->pekerjaan }}</li>
                            <li class="list-group-item"><strong>Penghasilan:</strong> Rp{{ number_format($portofolio->penghasilan, 0, ',', '.') }}</li>
                        </ul>
                        <a href="{{ route('portofolios.edit', $portofolio->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('portofolios.destroy', $portofolio->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data diri?')"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('portofolios.create') }}" class="btn btn-primary mb-3">+ Tambah Portofolio</a>
            @endif
        </div>
        <div class="col-lg-8">
            <h4 class="mb-3">Daftar Investasi UMKM</h4>
            @if(empty($investasiUmkms) || $investasiUmkms->isEmpty())
                <div class="alert alert-info">Belum ada investasi ke UMKM.</div>
            @else
                <div class="row g-3">
                    @foreach($investasiUmkms as $inv)
                        <div class="col-12">
                            <div class="card shadow-sm border-0 mb-2">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-2 text-center">
                                        <img src="{{ $inv->umkm && $inv->umkm->foto && file_exists(public_path('storage/'.$inv->umkm->foto)) ? asset('storage/'.$inv->umkm->foto) : 'https://via.placeholder.com/80x80?text=UMKM' }}" class="img-fluid rounded-circle" style="width:80px;height:80px;object-fit:cover;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body py-2">
                                            <h5 class="card-title mb-1">{{ $inv->umkm->nama }}</h5>
                                            <div class="mb-1"><strong>Total Investasi:</strong> Rp{{ number_format($inv->total_investasi, 0, ',', '.') }}</div>
                                            <div class="mb-1"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($inv->tanggal_mulai)->format('d M Y') }}</div>
                                            <div class="mb-1"><strong>Jangka Waktu:</strong> {{ $inv->umkm->durasi_investasi }} bulan</div>
                                            <div class="mb-1"><strong>Status:</strong> <span class="badge {{ $inv->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($inv->status) }}</span></div>
                                            @if($inv->status == 'berakhir')
                                                <div class="mb-1"><strong>Estimasi Bagi Hasil:</strong> Rp{{ number_format($inv->estimasi_bagi_hasil, 0, ',', '.') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
