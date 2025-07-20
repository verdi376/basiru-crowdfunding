@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manajemen Pembayaran Deviden</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>UMKM</th>
                                    <th>Status</th>
                                    <th>Total Investasi</th>
                                    <th>Periode Investasi</th>
                                    <th>Total Keuntungan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($umkms as $umkm)
                                    <tr>
                                        <td>
                                            <strong>{{ $umkm->nama }}</strong><br>
                                            <small class="text-muted">{{ $umkm->kategori }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $status = $umkm->status;
                                                $actionClass = $status == 'active' ? 'btn-primary' : 'btn-secondary';
                                                $actionIcon = $status == 'active' ? 'money-bill-wave' : 'check-circle';
                                                $actionText = $status == 'active' ? 'Proses Deviden' : 'Kembalikan Modal';
                                            @endphp
                                            <span class="badge bg-{{ $umkm->investment_period_end <= now() ? 'danger' : 'primary' }} text-white">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($umkm->totalActiveInvestment, 0, ',', '.') }}</td>
                                        <td>
                                            {{ $umkm->investment_period_start->format('d/m/Y') }} - 
                                            {{ $umkm->investment_period_end->format('d/m/Y') }}
                                            @if($umkm->investment_period_end <= now())
                                                <span class="badge bg-danger ms-2">Selesai</span>
                                            @else
                                                <div class="text-success">
                                                    <small>{{ $umkm->investment_period_end->diffForHumans() }} lagi</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($umkm->laporanPenjualan->sum('total_keuntungan'), 0, ',', '.') }}</td>
                                        <td>
                                            @if($umkm->investment_period_end <= now())
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#returnCapitalModal"
                                                    data-umkm-id="{{ $umkm->id }}">
                                                    <i class="fas fa-undo me-1"></i> Kembalikan Modal
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#processDividendModal"
                                                    data-umkm-id="{{ $umkm->id }}"
                                                    data-umkm-name="{{ $umkm->nama }}">
                                                    <i class="fas fa-money-bill-wave me-1"></i> Proses Deviden
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">Tidak ada UMKM yang memerlukan tindakan saat ini</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
    
    <!-- Daftar Riwayat Pembayaran -->
    <div class="card">
        <div class="card-header bg-light">
            <ul class="nav nav-tabs card-header-tabs" id="paymentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="dividends-tab" data-bs-toggle="tab" data-bs-target="#dividends" type="button" role="tab" aria-controls="dividends" aria-selected="true">
                        Riwayat Pembayaran Deviden
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="returns-tab" data-bs-toggle="tab" data-bs-target="#returns" type="button" role="tab" aria-controls="returns" aria-selected="false">
                        Riwayat Pengembalian Modal
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="paymentTabsContent">
                <!-- Tab Deviden -->
                <div class="tab-pane fade show active" id="dividends" role="tabpanel" aria-labelledby="dividends-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>UMKM</th>
                                    <th>Investor</th>
                                    <th>Periode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dividends as $index => $dividend)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($dividend->umkm->foto)
                                                    <img src="{{ asset('storage/' . $dividend->umkm->foto) }}" alt="{{ $dividend->umkm->nama }}" class="rounded-circle me-2" width="32" height="32">
                                                @else
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-store text-white" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $dividend->umkm->nama }}</div>
                                                    <small class="text-muted">{{ $dividend->umkm->kategori }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $dividend->investor->name }}</div>
                                                    <small class="text-muted">{{ $dividend->investor->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $dividend->periode }}</td>
                                        <td class="text-nowrap">Rp {{ number_format($dividend->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $dividend->status == 'paid' ? 'success' : 'warning' }} text-white">
                                                {{ $dividend->status == 'paid' ? 'Dibayar' : 'Menunggu' }}
                                                @if($dividend->status == 'paid')
                                                    <i class="fas fa-check-circle ms-1"></i>
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $dividend->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-nowrap">
                                            @if($dividend->status != 'paid')
                                                <form action="{{ route('admin.dividends.mark-paid', $dividend) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                                            onclick="return confirm('Tandai pembayaran deviden ini sebagai sudah dibayar?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Tandai Sudah Dibayar">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.dividends.show', $dividend) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">Belum ada riwayat pembayaran deviden</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
