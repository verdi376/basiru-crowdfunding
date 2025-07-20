@extends('admin.layout')

@section('title', 'Edit UMKM: ' . $umkm->nama)

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
        padding: 2rem;
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .profile-logo {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        border: 5px solid #fff;
        margin-top: -80px;
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
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    .form-control, .form-select {
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.umkm.show', $umkm->id) }}">{{ $umkm->nama }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Data UMKM</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama UMKM</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $umkm->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $umkm->kategori) }}" required>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dana_dibutuhkan" class="form-label">Dana Dibutuhkan (Rp)</label>
                                <input type="number" class="form-control @error('dana_dibutuhkan') is-invalid @enderror" id="dana_dibutuhkan" name="dana_dibutuhkan" value="{{ old('dana_dibutuhkan', $umkm->dana_dibutuhkan) }}" required>
                                @error('dana_dibutuhkan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" required>{{ old('alamat', $umkm->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi (Kota/Kabupaten)</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $umkm->lokasi) }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $umkm->telepon) }}" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kontak" class="form-label">Kontak (Email/WA/Telegram)</label>
                            <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $umkm->kontak) }}" required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="menunggu" {{ old('status', $umkm->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="aktif" {{ old('status', $umkm->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="ditolak" {{ old('status', $umkm->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="nonaktif" {{ old('status', $umkm->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo UMKM</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($umkm->logo)
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan_penolakan" class="form-label">Catatan Penolakan</label>
                            <textarea class="form-control @error('catatan_penolakan') is-invalid @enderror" id="catatan_penolakan" name="catatan_penolakan" rows="2">{{ old('catatan_penolakan', $umkm->catatan_penolakan) }}</textarea>
                            <small class="text-muted">Isi jika status ditolak</small>
                            @error('catatan_penolakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script untuk menampilkan preview logo
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-preview').src = e.target.result;
                document.getElementById('logo-preview').classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Script untuk menampilkan/menyembunyikan catatan penolakan berdasarkan status
    document.getElementById('status').addEventListener('change', function() {
        const catatanPenolakan = document.getElementById('catatan_penolakan');
        if (this.value === 'ditolak') {
            catatanPenolakan.setAttribute('required', 'required');
        } else {
            catatanPenolakan.removeAttribute('required');
        }
    });
    
    // Panggil event handler saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('status').dispatchEvent(new Event('change'));
    });
</script>
@endpush
