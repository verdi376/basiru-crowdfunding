@extends('admin.layout')

@section('title', 'Detail UMKM: ' . $umkm->nama)

@push('styles')
<style>
    .profile-header {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .profile-bg {
        height: 200px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    .profile-info {
        position: relative;
        padding: 0 2rem 2rem;
        background: #fff;
    }
    .profile-logo {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        border: 5px solid #fff;
        margin-top: -60px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #6c757d;
        overflow: hidden;
    }
    .profile-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-stats {
        display: flex;
        gap: 1.5rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .card {
        height: 100%;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-title {
        color: #333;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .info-item {
        display: flex;
        margin-bottom: 0.75rem;
    }
    .info-label {
        width: 150px;
        color: #6c757d;
        font-weight: 500;
    }
    .info-value {
        flex: 1;
        color: #333;
    }
    .badge-status {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
    }
    .gallery-item {
        position: relative;
        height: 200px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .gallery-item:hover .overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail UMKM</li>
        </ol>
    </nav>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.umkm.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div class="btn-group">
            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusUmkm({{ $umkm->id }})">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>

<div class="profile-header">
    <div class="profile-bg"></div>
    <div class="profile-info">
        <div class="d-flex align-items-center">
            <div class="profile-logo me-4">
                @if($umkm->logo)
                    <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->nama }}">
                @else
                    <i class="bi bi-shop"></i>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="mb-1">{{ $umkm->nama }}</h2>
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt me-1"></i> {{ $umkm->alamat }}, {{ $umkm->kota }}
                            @if($umkm->status == 'aktif')
                                <span class="badge bg-success ms-2">Aktif</span>
                            @elseif($umkm->status == 'menunggu')
                                <span class="badge bg-warning text-dark ms-2">Menunggu Verifikasi</span>
                            @elseif($umkm->status == 'ditolak')
                                <span class="badge bg-danger ms-2">Ditolak</span>
                            @else
                                <span class="badge bg-secondary ms-2">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Ubah Status
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                            <li><a class="dropdown-item" href="#" onclick="updateStatus('aktif')">Aktif</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateStatus('menunggu')">Menunggu</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateStatus('ditolak')">Tolak</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateStatus('nonaktif')">Nonaktifkan</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-2">
                    <span class="me-3"><i class="bi bi-tag me-1"></i> {{ $umkm->kategori }}</span>
                    <span class="me-3"><i class="bi bi-telephone me-1"></i> {{ $umkm->no_telepon ?? '-' }}</span>
                    <span><i class="bi bi-envelope me-1"></i> {{ $umkm->email ?? '-' }}</span>
                </div>
                
                <p class="mb-0">{{ $umkm->deskripsi_singkat }}</p>
            </div>
        </div>
        
        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($umkm->total_investasi, 0, ',', '.') }}</div>
                <div class="stat-label">Total Investasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($umkm->jumlah_investor) }}</div>
                <div class="stat-label">Investor</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($umkm->keuntungan_tahunan ?? 0, 2) }}%</div>
                <div class="stat-label">Keuntungan Tahunan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $umkm->umur_bisnis ?? '0' }}</div>
                <div class="stat-label">Tahun Berdiri</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi UMKM -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-info-circle me-2"></i> Informasi UMKM
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Nama UMKM</div>
                            <div class="info-value">{{ $umkm->nama }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Kategori</div>
                            <div class="info-value">{{ $umkm->kategori }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tahun Berdiri</div>
                            <div class="info-value">{{ $umkm->tahun_berdiri ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Alamat</div>
                            <div class="info-value">{{ $umkm->alamat }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">Kota/Kabupaten</div>
                            <div class="info-value">{{ $umkm->kota }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Provinsi</div>
                            <div class="info-value">{{ $umkm->provinsi }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Kode Pos</div>
                            <div class="info-value">{{ $umkm->kode_pos ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">{{ $umkm->no_telepon ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $umkm->email ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Website</div>
                            <div class="info-value">
                                @if($umkm->website)
                                    <a href="{{ $umkm->website }}" target="_blank">{{ $umkm->website }}</a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="card-title">
                    <i class="bi bi-file-text me-2"></i> Deskripsi Lengkap
                </h5>
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($umkm->deskripsi_lengkap)) ?: '<span class="text-muted">Tidak ada deskripsi</span>' !!}
                </div>
                
                @if($umkm->visi || $umkm->misi)
                <hr class="my-4">
                
                <div class="row">
                    @if($umkm->visi)
                    <div class="col-md-6">
                        <h5 class="card-title">
                            <i class="bi bi-eye me-2"></i> Visi
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($umkm->visi)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($umkm->misi)
                    <div class="col-md-6">
                        <h5 class="card-title">
                            <i class="bi bi-bullseye me-2"></i> Misi
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($umkm->misi)) !!}
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Informasi Tambahan -->
    <div class="col-md-4 mb-4">
        <!-- Informasi Pemilik -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-person me-2"></i> Pemilik UMKM
                </h5>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 me-3">
                        @if($umkm->pemilik && $umkm->pemilik->foto_profil)
                            <img src="{{ asset('storage/' . $umkm->pemilik->foto_profil) }}" 
                                 alt="{{ $umkm->pemilik->name }}" 
                                 class="rounded-circle" 
                                 width="60" 
                                 height="60" 
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $umkm->pemilik->name ?? 'Pemilik Tidak Ditemukan' }}</h6>
                        <small class="text-muted">{{ $umkm->pemilik->email ?? '-' }}</small>
                        <div>
                            <small class="text-muted">
                                <i class="bi bi-telephone me-1"></i> {{ $umkm->pemilik->no_telepon ?? '-' }}
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid mt-2">
                    <a href="{{ $umkm->pemilik ? route('admin.investor.show', $umkm->pemilik->id) : '#' }}" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-person-lines"></i> Lihat Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Dokumen UMKM -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-files me-2"></i> Dokumen
                </h5>
                
                <div class="list-group list-group-flush">
                    @if($umkm->dokumen_akta_pendirian)
                    <a href="{{ asset('storage/' . $umkm->dokumen_akta_pendirian) }}" 
                       target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> Akta Pendirian</span>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if($umkm->dokumen_siup)
                    <a href="{{ asset('storage/' . $umkm->dokumen_siup) }}" 
                       target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> SIUP</span>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if($umkm->dokumen_nib)
                    <a href="{{ asset('storage/' . $umkm->dokumen_nib) }}" 
                       target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> NIB</span>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if($umkm->dokumen_ktp)
                    <a href="{{ asset('storage/' . $umkm->dokumen_ktp) }}" 
                       target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-image me-2 text-primary"></i> KTP Pemilik</span>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if($umkm->dokumen_laporan_keuangan)
                    <a href="{{ asset('storage/' . $umkm->dokumen_laporan_keuangan) }}" 
                       target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i> Laporan Keuangan</span>
                        <i class="bi bi-download"></i>
                    </a>
                    @endif
                    
                    @if(!$umkm->dokumen_akta_pendirian && !$umkm->dokumen_siup && !$umkm->dokumen_nib && !$umkm->dokumen_ktp && !$umkm->dokumen_laporan_keuangan)
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-folder-x" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada dokumen</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Galeri -->
        @if($umkm->galeri && count($umkm->galeri) > 0)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-images me-2"></i> Galeri
                </h5>
                
                <div class="row g-2">
                    @foreach($umkm->galeri as $foto)
                    <div class="col-6">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $foto) }}" alt="Galeri {{ $loop->iteration }}">
                            <div class="overlay">
                                <a href="{{ asset('storage/' . $foto) }}" 
                                   class="btn btn-sm btn-light" 
                                   data-fslightbox="gallery">
                                    <i class="bi bi-zoom-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Tab Navigasi -->
<ul class="nav nav-tabs mb-4" id="umkmTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id=
