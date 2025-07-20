@extends('admin.layout')

@section('title', 'Daftar UMKM')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
        color: #333;
    }
    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
        padding: 1rem 1.5rem;
    }
    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
    }
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .umkm-logo {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        object-fit: cover;
    }
    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data UMKM</li>
        </ol>
    </nav>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download"></i> Ekspor
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>
        <a href="#" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah UMKM
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar UMKM</h5>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari UMKM...">
            <button class="btn btn-outline-secondary btn-sm" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="umkmTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama UMKM</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Total Investasi</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($umkms as $umkm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($umkm->logo)
                                    <img src="{{ asset('storage/' . $umkm->logo) }}" 
                                         alt="{{ $umkm->nama }}" 
                                         class="umkm-logo me-2">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center umkm-logo me-2">
                                        <i class="bi bi-shop text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-medium">{{ $umkm->nama }}</div>
                                    <small class="text-muted">{{ $umkm->kota }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    @if($umkm->pemilik && $umkm->pemilik->foto_profil)
                                        <img src="{{ asset('storage/' . $umkm->pemilik->foto_profil) }}" 
                                             alt="{{ $umkm->pemilik->name ?? 'Pemilik' }}" 
                                             class="rounded-circle" 
                                             width="30" 
                                             height="30" 
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div>{{ $umkm->pemilik->name ?? 'Pemilik Tidak Ditemukan' }}</div>
                                    <small class="text-muted">{{ $umkm->pemilik->email ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $umkm->kategori }}</span>
                        </td>
                        <td>
                            <div class="fw-medium">Rp {{ number_format($umkm->total_investasi, 0, ',', '.') }}</div>
                            <small class="text-muted">{{ $umkm->jumlah_investor }} investor</small>
                        </td>
                        <td>
                            @if($umkm->status == 'aktif')
                                <span class="badge bg-success status-badge">Aktif</span>
                            @elseif($umkm->status == 'menunggu')
                                <span class="badge bg-warning text-dark status-badge">Menunggu</span>
                            @elseif($umkm->status == 'ditolak')
                                <span class="badge bg-danger status-badge">Ditolak</span>
                            @else
                                <span class="badge bg-secondary status-badge">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $umkm->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $umkm->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.umkm.show', $umkm->id) }}" 
                                   class="btn btn-outline-primary" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="#" 
                                   class="btn btn-outline-success" 
                                   data-bs-toggle="tooltip" 
                                   title="Verifikasi"
                                   onclick="verifikasiUmkm({{ $umkm->id }})">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                                <a href="#" 
                                   class="btn btn-outline-danger" 
                                   data-bs-toggle="tooltip" 
                                   title="Tolak"
                                   onclick="tolakUmkm({{ $umkm->id }})">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Belum ada data UMKM</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($umkms->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Menampilkan {{ $umkms->firstItem() }} - {{ $umkms->lastItem() }} dari {{ $umkms->total() }} data
        </div>
        <div>
            {{ $umkms->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="verifikasiForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="aktif">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin memverifikasi UMKM ini?</p>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Berikan catatan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="tolakForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Verifikasi UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak verifikasi UMKM ini?</p>
                    <div class="mb-3">
                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alasan_penolakan" name="catatan" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    // Inisialisasi DataTable
    $(document).ready(function() {
        const table = $('#umkmTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            columnDefs: [
                { orderable: false, targets: [0, 7] },
                { searchable: false, targets: [0, 5, 6, 7] }
            ],
            order: [[6, 'desc']],
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
            initComplete: function() {
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_length select').addClass('form-select form-select-sm');
            }
        });

        // Pencarian dengan delay
        let searchTimeout;
        $('#searchInput').keyup(function() {
            clearTimeout(searchTimeout);
            const searchTerm = $(this).val();
            searchTimeout = setTimeout(function() {
                table.search(searchTerm).draw();
            }, 500);
        });
    });

    // Fungsi untuk menampilkan modal verifikasi
    function verifikasiUmkm(id) {
        const form = document.getElementById('verifikasiForm');
        form.action = `/admin/umkm/${id}/verifikasi`;
        const modal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
        modal.show();
    }

    // Fungsi untuk menampilkan modal tolak
    function tolakUmkm(id) {
        const form = document.getElementById('tolakForm');
        form.action = `/admin/umkm/${id}/tolak`;
        form.reset(); // Reset form untuk menghapus input sebelumnya
        const modal = new bootstrap.Modal(document.getElementById('tolakModal'));
        
        // Tampilkan modal
        modal.show();
        
        // Fokus ke textarea alasan penolakan
        setTimeout(() => {
            document.getElementById('alasan_penolakan').focus();
        }, 500);
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
