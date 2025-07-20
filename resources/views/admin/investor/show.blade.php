@extends('admin.layout')

@section('title', 'Detail Investor: ' . $investor->name)

@push('styles')
<style>
    .profile-header {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .profile-bg {
        height: 150px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    .profile-info {
        position: relative;
        padding: 0 2rem 2rem;
        background: #fff;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
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
    .profile-avatar img {
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
        width: 120px;
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
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.investor.index') }}">Data Investor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Investor</li>
        </ol>
    </nav>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.investor.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-printer"></i> Cetak
            </button>
            <a href="#" class="btn btn-sm btn-outline-success">
                <i class="bi bi-envelope"></i> Kirim Email
            </a>
        </div>
    </div>
</div>

<div class="profile-header">
    <div class="profile-bg"></div>
    <div class="profile-info">
        <div class="d-flex align-items-center">
            <div class="profile-avatar me-4">
                @if($investor->foto_profil)
                    <img src="{{ asset('storage/' . $investor->foto_profil) }}" alt="{{ $investor->name }}">
                @else
                    <i class="bi bi-person"></i>
                @endif
            </div>
            <div>
                <h2 class="mb-1">{{ $investor->name }}</h2>
                <p class="text-muted mb-2">
                    <i class="bi bi-envelope me-1"></i> {{ $investor->email }}
                    @if($investor->is_verified)
                        <span class="badge bg-success badge-status ms-2">
                            <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                        </span>
                    @else
                        <span class="badge bg-warning text-dark badge-status ms-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Belum Diverifikasi
                        </span>
                    @endif
                </p>
                <div class="d-flex align-items-center">
                    <span class="me-3"><i class="bi bi-telephone me-1"></i> {{ $investor->no_telepon ?? '-' }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i> Bergabung pada {{ $investor->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        
        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($investor->investments_count) }}</div>
                <div class="stat-label">Total Investasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($investor->investments_sum_jumlah_investasi ?? 0, 0, ',', '.') }}</div>
                <div class="stat-label">Total Nilai Investasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($investor->dividends_count) }}</div>
                <div class="stat-label">Total Dividen Diterima</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($investor->dividends_sum_jumlah ?? 0, 0, ',', '.') }}</div>
                <div class="stat-label">Total Nilai Dividen</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Pribadi -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-person-lines-fill me-2"></i> Informasi Pribadi
                </h5>
                <div class="info-item">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $investor->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $investor->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $investor->no_telepon ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $investor->alamat ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value">
                        {{ $investor->tanggal_lahir ? $investor->tanggal_lahir->format('d M Y') : '-' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">
                        @if($investor->jenis_kelamin == 'L')
                            Laki-laki
                        @elseif($investor->jenis_kelamin == 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status Verifikasi</div>
                    <div class="info-value">
                        @if($investor->is_verified)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Rekening -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-credit-card me-2"></i> Informasi Rekening
                    </h5>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                
                @if($investor->rekening_bank)
                    <div class="info-item">
                        <div class="info-label">Nama Bank</div>
                        <div class="info-value">{{ $investor->rekening_bank->nama_bank ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nomor Rekening</div>
                        <div class="info-value">{{ $investor->rekening_bank->nomor_rekening ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Atas Nama</div>
                        <div class="info-value">{{ $investor->rekening_bank->atas_nama ?? '-' }}</div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-credit-card text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada informasi rekening</p>
                    </div>
                @endif
                
                <hr class="my-4">
                
                <h6 class="fw-bold mb-3">Riwayat Transaksi Terbaru</h6>
                @if($investor->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($investor->transactions->take(5) as $transaction)
                                    <tr>
                                        <td>#{{ $transaction->id }}</td>
                                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                        <td>{{ ucfirst($transaction->jenis) }}</td>
                                        <td>Rp {{ number_format($transaction->nominal, 0, ',', '.') }}</td>
                                        <td>
                                            @if($transaction->status == 'sukses')
                                                <span class="badge bg-success">Sukses</span>
                                            @elseif($transaction->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-danger">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="#" class="btn btn-sm btn-link">Lihat Semua Transaksi</a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-credit-card text-muted" style="font-size: 1.5rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada riwayat transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Daftar Investasi -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-graph-up me-2"></i> Portofolio Investasi
            </h5>
            <div>
                <button class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-download"></i> Ekspor
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Investasi
                </button>
            </div>
        </div>
        
        @if($investor->investments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UMKM</th>
                            <th>Tanggal Investasi</th>
                            <th>Jumlah Investasi</th>
                            <th>Harga Perlembar</th>
                            <th>Total Lembar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investor->investments as $investment)
                            <tr>
                                <td>#{{ $investment->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($investment->umkm->logo)
                                            <img src="{{ asset('storage/' . $investment->umkm->logo) }}" 
                                                 alt="{{ $investment->umkm->nama }}" 
                                                 class="rounded me-2" 
                                                 width="40" 
                                                 height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi bi-shop text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $investment->umkm->nama }}</h6>
                                            <small class="text-muted">{{ $investment->umkm->kategori }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $investment->created_at->format('d M Y') }}</td>
                                <td>Rp {{ number_format($investment->jumlah_investasi, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($investment->harga_perlembar, 0, ',', '.') }}</td>
                                <td>{{ number_format($investment->jumlah_lembar, 0, ',', '.') }} Lembar</td>
                                <td>
                                    @if($investment->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($investment->status == 'selesai')
                                        <span class="badge bg-info">Selesai</span>
                                    @elseif($investment->status == 'dibatalkan')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada riwayat investasi</p>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Mulai Berinvestasi
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Daftar Dividen -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-cash-coin me-2"></i> Riwayat Dividen
            </h5>
            <button class="btn btn-sm btn-outline-primary">
                <i class="bi bi-download"></i> Ekspor
            </button>
        </div>
        
        @if($investor->dividends->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>UMKM</th>
                            <th>Periode</th>
                            <th>Jumlah Lembar</th>
                            <th>Dividen Per Lembar</th>
                            <th>Total Dividen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investor->dividends as $dividend)
                            <tr>
                                <td>#{{ $dividend->id }}</td>
                                <td>{{ $dividend->created_at->format('d M Y') }}</td>
                                <td>{{ $dividend->umkm->nama }}</td>
                                <td>
                                    {{ $dividend->periode_awal->format('M Y') }} - 
                                    {{ $dividend->periode_akhir->format('M Y') }}
                                </td>
                                <td>{{ number_format($dividend->jumlah_lembar, 0, ',', '.') }} Lembar</td>
                                <td>Rp {{ number_format($dividend->dividen_perlembar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($dividend->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if($dividend->status == 'dibayar')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif($dividend->status == 'belum_dibayar')
                                        <span class="badge bg-warning text-dark">Belum Dibayar</span>
                                    @else
                                        <span class="badge bg-secondary">Diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-cash-coin text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada riwayat dividen</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Investor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ $investor->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $investor->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" name="no_telepon" value="{{ $investor->no_telepon ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3">{{ $investor->alamat ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select class="form-select" name="is_verified">
                            <option value="1" {{ $investor->is_verified ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="0" {{ !$investor->is_verified ? 'selected' : '' }}>Belum Diverifikasi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Rekening -->
<div class="modal fade" id="addRekeningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.investor.rekening.store', $investor->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rekening Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bank</label>
                        <input type="text" class="form-control" name="nama_bank" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" name="nomor_rekening" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" name="atas_nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan modal edit
    function editInvestor() {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        const form = document.getElementById('editForm');
        form.action = '{{ route('admin.investor.update', $investor->id) }}';
        modal.show();
    }
    
    // Fungsi untuk menampilkan modal tambah rekening
    function showAddRekeningModal() {
        const modal = new bootstrap.Modal(document.getElementById('addRekeningModal'));
        modal.show();
    }
    
    // Inisialisasi tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
