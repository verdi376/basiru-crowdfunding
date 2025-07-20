@extends('admin.layout')

@section('title', 'Kelola Metode Pembayaran')

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
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    .badge-bank {
        background-color: #4e73df;
    }
    .badge-ewallet {
        background-color: #1cc88a;
    }
    .badge-qris {
        background-color: #f6c23e;
        color: #000;
    }
    .logo-bank {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #e3e6f0;
    }
</style>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Metode Pembayaran</h1>
    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahMetodeModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Metode
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Metode Pembayaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Tipe</th>
                        <th>Nomor Rekening</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($metodes as $metode)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if($metode->logo)
                                <img src="{{ asset('storage/' . $metode->logo) }}" alt="{{ $metode->nama }}" class="logo-bank">
                            @else
                                <div class="logo-bank bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-money-bill-wave text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $metode->nama }}</td>
                        <td><code>{{ $metode->kode }}</code></td>
                        <td>
                            @php
                                $badgeClass = 'badge-' . $metode->tipe;
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $metode->tipe_text }}
                            </span>
                        </td>
                        <td>{{ $metode->nomor_rekening ?? '-' }}</td>
                        <td>
                            @if($metode->status)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info btn-edit" 
                                    data-id="{{ $metode->id }}"
                                    data-nama="{{ $metode->nama }}"
                                    data-kode="{{ $metode->kode }}"
                                    data-tipe="{{ $metode->tipe }}"
                                    data-nomor-rekening="{{ $metode->nomor_rekening }}"
                                    data-atas-nama="{{ $metode->atas_nama }}"
                                    data-status="{{ $metode->status }}"
                                    data-keterangan="{{ $metode->keterangan }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.pengaturan.pembayaran.hapus', $metode->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data metode pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Metode -->
<div class="modal fade" id="tambahMetodeModal" tabindex="-1" aria-labelledby="tambahMetodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pengaturan.pembayaran.tambah') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahMetodeModalLabel">Tambah Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Metode</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Unik</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                        <small class="text-muted">Kode unik untuk integrasi sistem (contoh: BCA, MANDIRI, GOPAY, etc)</small>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" id="tipe" name="tipe" required>
                            <option value="">Pilih Tipe</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-3" id="nomorRekeningGroup">
                        <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening">
                    </div>
                    <div class="mb-3" id="atasNamaGroup">
                        <label for="atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, PNG</small>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                        <label class="form-check-label" for="status">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Metode -->
<div class="modal fade" id="editMetodeModal" tabindex="-1" aria-labelledby="editMetodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMetodeForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editMetodeModalLabel">Edit Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Metode</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kode" class="form-label">Kode Unik</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode" required>
                        <small class="text-muted">Kode unik untuk integrasi sistem (contoh: BCA, MANDIRI, GOPAY, etc)</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tipe" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" id="edit_tipe" name="tipe" required>
                            <option value="bank">Bank Transfer</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-3" id="edit_nomorRekeningGroup">
                        <label for="edit_nomor_rekening" class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" id="edit_nomor_rekening" name="nomor_rekening">
                    </div>
                    <div class="mb-3" id="edit_atasNamaGroup">
                        <label for="edit_atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" id="edit_atas_nama" name="atas_nama">
                    </div>
                    <div class="mb-3">
                        <label for="edit_logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo</small>
                        <div id="currentLogo" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="edit_status" name="status" value="1">
                        <label class="form-check-label" for="edit_status">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Sembunyikan field nomor rekening dan atas nama secara default
        toggleRekeningFields();
        
        // Tampilkan/sembunyikan field nomor rekening dan atas nama berdasarkan tipe pembayaran
        $('#tipe, #edit_tipe').on('change', function() {
            toggleRekeningFields(this.id);
        });
        
        function toggleRekeningFields(fieldId = 'tipe') {
            const isBank = $('#' + fieldId).val() === 'bank';
            const prefix = fieldId === 'edit_tipe' ? 'edit_' : '';
            
            if (isBank) {
                $('#' + prefix + 'nomorRekeningGroup, #' + prefix + 'atasNamaGroup').show();
                $('#' + prefix + 'nomor_rekening, #' + prefix + 'atas_nama').prop('required', true);
            } else {
                $('#' + prefix + 'nomorRekeningGroup, #' + prefix + 'atasNamaGroup').hide();
                $('#' + prefix + 'nomor_rekening, #' + prefix + 'atas_nama').prop('required', false);
            }
        }
        
        // Handle tombol edit
        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            const url = '{{ url("admin/pengaturan/pembayaran") }}/' + id;
            
            $('#editMetodeForm').attr('action', url);
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_kode').val($(this).data('kode'));
            $('#edit_tipe').val($(this).data('tipe'));
            $('#edit_nomor_rekening').val($(this).data('nomor-rekening') || '');
            $('#edit_atas_nama').val($(this).data('atas-nama') || '');
            $('#edit_keterangan').val($(this).data('keterangan') || '');
            $('#edit_status').prop('checked', $(this).data('status') == 1);
            
            // Tampilkan logo saat ini jika ada
            const logoUrl = $(this).closest('tr').find('img').attr('src');
            if (logoUrl && !logoUrl.includes('money-bill-wave')) {
                $('#currentLogo').html(`
                    <p class="mb-1">Logo Saat Ini:</p>
                    <img src="${logoUrl}" alt="Current Logo" style="max-height: 50px;" class="img-thumbnail">
                `);
            } else {
                $('#currentLogo').html('<p class="text-muted mb-0">Tidak ada logo</p>');
            }
            
            // Toggle field nomor rekening dan atas nama
            toggleRekeningFields('edit_tipe');
            
            // Tampilkan modal edit
            const editModal = new bootstrap.Modal(document.getElementById('editMetodeModal'));
            editModal.show();
        });
        
        // Inisialisasi DataTable
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }
        
        $('#dataTable').DataTable({
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 7] }
            ]
        });
    });
</script>
@endpush
