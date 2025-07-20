@extends('admin.layout')

@section('title', 'Laporan Transaksi')

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }
    .table th {
        font-weight: 600;
        color: #4e73df;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        border-top: none;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    .badge-success {
        background-color: #1cc88a;
    }
    .badge-warning {
        background-color: #f6c23e;
        color: #000;
    }
    .badge-danger {
        background-color: #e74a3b;
    }
    .badge-secondary {
        background-color: #858796;
    }
</style>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
    <div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btn-export">
            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ request()->url() }}?status=all">Semua Status</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ request()->url() }}?status=sukses">Sukses</a>
                <a class="dropdown-item" href="{{ request()->url() }}?status=pending">Pending</a>
                <a class="dropdown-item" href="{{ request()->url() }}?status=gagal">Gagal</a>
                <a class="dropdown-item" href="{{ request()->url() }}?status=dibatalkan">Dibatalkan</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Pengguna</th>
                        <th>Jenis</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration + (($transaksis->currentPage() - 1) * $transaksis->perPage()) }}</td>
                        <td>{{ $transaksi->kode_transaksi }}</td>
                        <td>{{ $transaksi->user->name }}</td>
                        <td>{{ ucfirst($transaksi->jenis) }}</td>
                        <td>{{ $transaksi->metodePembayaran->nama ?? 'Tunai' }}</td>
                        <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if($transaksi->status == 'sukses')
                                <span class="badge badge-success">Sukses</span>
                            @elseif($transaksi->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($transaksi->status == 'gagal')
                                <span class="badge badge-danger">Gagal</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($transaksi->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-labelledby="detailTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTransaksiModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailTransaksiContent">
                <!-- Konten akan diisi via AJAX -->
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-print">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Tangkap klik tombol detail
        $('.btn-detail').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            
            // Tampilkan loading
            $('#detailTransaksiContent').html(`
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
            
            // Tampilkan modal
            var modal = new bootstrap.Modal(document.getElementById('detailTransaksiModal'));
            modal.show();
            
            // Ambil data via AJAX
            $.get(url, function(data) {
                $('#detailTransaksiContent').html(data);
            }).fail(function() {
                $('#detailTransaksiContent').html(`
                    <div class="alert alert-danger">
                        Gagal memuat detail transaksi. Silakan coba lagi.
                    </div>
                `);
            });
        });
        
        // Tangkap klik tombol cetak
        $('#btn-print').click(function() {
            window.print();
        });
        
        // Tangkap klik tombol export
        $('#btn-export').click(function(e) {
            e.preventDefault();
            // Tambahkan logika export di sini
            window.location.href = '{{ route("admin.laporan.transaksi") }}?export=excel';
        });
    });
</script>
@endpush
