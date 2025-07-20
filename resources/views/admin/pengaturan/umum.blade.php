@extends('admin.layout')

@section('title', 'Pengaturan Umum')

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
    .form-label {
        font-weight: 600;
        color: #4e73df;
    }
    .form-control, .form-select {
        border-radius: 0.35rem;
        padding: 0.75rem 1rem;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    .setting-icon {
        font-size: 1.5rem;
        color: #4e73df;
        margin-right: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan Umum</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex align-items-center">
                <i class="fas fa-cog setting-icon"></i>
                <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Aplikasi</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan.umum.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror" 
                               id="nama_aplikasi" name="nama_aplikasi" 
                               value="{{ old('nama_aplikasi', $settings['nama_aplikasi'] ?? '') }}" required>
                        @error('nama_aplikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email_admin" class="form-label">Email Admin</label>
                            <input type="email" class="form-control @error('email_admin') is-invalid @enderror" 
                                   id="email_admin" name="email_admin" 
                                   value="{{ old('email_admin', $settings['email_admin'] ?? '') }}" required>
                            @error('email_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telepon_admin" class="form-label">Telepon Admin</label>
                            <input type="text" class="form-control @error('telepon_admin') is-invalid @enderror" 
                                   id="telepon_admin" name="telepon_admin" 
                                   value="{{ old('telepon_admin', $settings['telepon_admin'] ?? '') }}" required>
                            @error('telepon_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
                        <textarea class="form-control @error('alamat_kantor') is-invalid @enderror" 
                                 id="alamat_kantor" name="alamat_kantor" 
                                 rows="3" required>{{ old('alamat_kantor', $settings['alamat_kantor'] ?? '') }}</textarea>
                        @error('alamat_kantor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="biaya_admin" class="form-label">Biaya Admin (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('biaya_admin') is-invalid @enderror" 
                                       id="biaya_admin" name="biaya_admin" 
                                       value="{{ old('biaya_admin', $settings['biaya_admin'] ?? '') }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                                @error('biaya_admin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="maks_investasi" class="form-label">Maksimal Investasi per Proyek</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('maks_investasi') is-invalid @enderror" 
                                       id="maks_investasi" name="maks_investasi" 
                                       value="{{ old('maks_investasi', $settings['maks_investasi'] ?? '') }}" 
                                       min="100000" required>
                                @error('maks_investasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex align-items-center">
                <i class="fas fa-info-circle setting-icon"></i>
                <h6 class="m-0 font-weight-bold text-primary">Informasi Aplikasi</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Aplikasi" class="img-fluid" style="max-height: 100px;">
                    <h5 class="mt-3">{{ config('app.name') }}</h5>
                    <p class="text-muted">Versi {{ config('app.version', '1.0.0') }}</p>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-code-branch me-2"></i> Versi Laravel</span>
                        <span class="badge bg-primary">{{ app()->version() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-server me-2"></i> Environment</span>
                        <span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-globe me-2"></i> URL Aplikasi</span>
                        <span class="text-muted small">{{ config('app.url') }}</span>
                    </li>
                </ul>
                
                <div class="mt-4">
                    <h6 class="font-weight-bold">Statistik Aplikasi</h6>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h4 class="mb-0">{{ \App\Models\User::count() }}</h4>
                                <small class="text-muted">Pengguna</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h4 class="mb-0">{{ \App\Models\Umkm::count() }}</h4>
                                <small class="text-muted">UMKM</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h4 class="mb-0">{{ \App\Models\Transaksi::count() }}</h4>
                                <small class="text-muted">Transaksi</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h4 class="mb-0">Rp {{ number_format(\App\Models\Transaksi::where('status', 'sukses')->sum('jumlah'), 0, ',', '.') }}</h4>
                                <small class="text-muted">Total Investasi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Format input number dengan pemisah ribuan
        $('#maks_investasi').on('keyup', function() {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(value);
        });
        
        // Validasi form sebelum submit
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Validasi email
            const email = $('#email_admin').val();
            if (!isValidEmail(email)) {
                $('#email_admin').addClass('is-invalid');
                $('#email_admin').next('.invalid-feedback').text('Format email tidak valid');
                isValid = false;
            }
            
            // Validasi biaya admin
            const biayaAdmin = parseFloat($('#biaya_admin').val());
            if (isNaN(biayaAdmin) || biayaAdmin < 0 || biayaAdmin > 100) {
                $('#biaya_admin').addClass('is-invalid');
                $('#biaya_admin').next('.invalid-feedback').text('Biaya admin harus antara 0% - 100%');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                showAlert('error', 'Terdapat kesalahan pada form. Silakan periksa kembali.');
            }
        });
        
        // Fungsi validasi email
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }
        
        // Tampilkan alert
        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Hapus alert sebelumnya jika ada
            $('.alert').remove();
            
            // Tambahkan alert baru
            $('.card-body').prepend(alertHtml);
            
            // Auto close alert setelah 5 detik
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }
    });
</script>
@endpush
