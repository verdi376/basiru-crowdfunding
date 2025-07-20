@extends('admin.layout')

@section('title', 'Data Investor')

@push('styles')
<style>
    .profile-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Investor</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Ekspor</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Impor</button>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="investorTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Total Investasi</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investors as $investor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($investor->foto_profil)
                                        <img src="{{ asset('storage/' . $investor->foto_profil) }}" 
                                             alt="{{ $investor->name }}" 
                                             class="profile-img me-2">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $investor->name }}</h6>
                                        <small class="text-muted">@ {{ $investor->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $investor->email }}</td>
                            <td>Rp {{ number_format($investor->investments_sum_jumlah_investasi ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($investor->is_verified)
                                    <span class="badge bg-success status-badge">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark status-badge">Belum Diverifikasi</span>
                                @endif
                            </td>
                            <td>{{ $investor->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.investor.show', $investor->id) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-secondary" 
                                            title="Verifikasi"
                                            onclick="verifikasiInvestor({{ $investor->id }}, {{ $investor->is_verified ? 'false' : 'true' }})">
                                        @if($investor->is_verified)
                                            <i class="bi bi-x-circle"></i>
                                        @else
                                            <i class="bi bi-check-circle"></i>
                                        @endif
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            title="Hapus"
                                            onclick="hapusInvestor({{ $investor->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-people fs-1 text-muted"></i>
                                <p class="text-muted mb-0">Belum ada data investor</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($investors->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $investors->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="verifikasiForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Investor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="verifikasiText">Apakah Anda yakin ingin memverifikasi investor ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="hapusForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Investor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus investor ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi DataTable
    $(document).ready(function() {
        $('#investorTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 6] },
                { searchable: false, targets: [0, 3, 4, 5, 6] }
            ],
            order: [[1, 'asc']]
        });
    });

    // Fungsi untuk verifikasi investor
    function verifikasiInvestor(id, verify) {
        const modal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
        const form = document.getElementById('verifikasiForm');
        const text = document.getElementById('verifikasiText');
        
        form.action = `/admin/investor/${id}/verifikasi`;
        
        if (verify) {
            text.textContent = 'Apakah Anda yakin ingin memverifikasi investor ini?';
            form.querySelector('button[type="submit"]').textContent = 'Ya, Verifikasi';
            form.querySelector('button[type="submit"]').className = 'btn btn-primary';
        } else {
            text.textContent = 'Apakah Anda yakin ingin membatalkan verifikasi investor ini?';
            form.querySelector('button[type="submit"]').textContent = 'Ya, Batalkan Verifikasi';
            form.querySelector('button[type="submit"]').className = 'btn btn-warning';
        }
        
        modal.show();
    }

    // Fungsi untuk hapus investor
    function hapusInvestor(id) {
        const modal = new bootstrap.Modal(document.getElementById('hapusModal'));
        const form = document.getElementById('hapusForm');
        
        form.action = `/admin/investor/${id}`;
        modal.show();
    }
</script>
@endpush
