@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Laporan Penjualan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('umkm.laporan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="periode_awal" class="form-label">Periode Awal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('periode_awal') is-invalid @enderror" 
                                           id="periode_awal" name="periode_awal" value="{{ old('periode_awal') }}" required>
                                    @error('periode_awal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="periode_akhir" class="form-label">Periode Akhir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('periode_akhir') is-invalid @enderror" 
                                           id="periode_akhir" name="periode_akhir" value="{{ old('periode_akhir') }}" required>
                                    @error('periode_akhir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_penjualan" class="form-label">Total Penjualan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('total_penjualan') is-invalid @enderror" 
                                           id="total_penjualan" name="total_penjualan" min="0" step="1000" value="{{ old('total_penjualan') }}" required>
                                    @error('total_penjualan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_keuntungan" class="form-label">Total Keuntungan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('total_keuntungan') is-invalid @enderror" 
                                           id="total_keuntungan" name="total_keuntungan" min="0" step="1000" value="{{ old('total_keuntungan') }}" required>
                                    @error('total_keuntungan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File Laporan (PDF/ZIP/RAR, maks: 10MB) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept=".pdf,.zip,.rar" required>
                            <div class="form-text">
                                Unggah file laporan dalam format PDF atau arsip (ZIP/RAR) yang berisi bukti penjualan.
                            </div>
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('umkm.laporan.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validasi tanggal akhir tidak boleh sebelum tanggal awal
    document.getElementById('periode_awal').addEventListener('change', function() {
        const endDate = document.getElementById('periode_akhir');
        if (this.value) {
            endDate.min = this.value;
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        }
    });

    // Format input angka dengan pemisah ribuan
    document.getElementById('total_penjualan').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value ? parseInt(value).toLocaleString('id-ID') : '';
    });

    document.getElementById('total_keuntungan').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value ? parseInt(value).toLocaleString('id-ID') : '';
    });

    // Konversi kembali ke angka sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const totalPenjualan = document.getElementById('total_penjualan');
        const totalKeuntungan = document.getElementById('total_keuntungan');
        
        if (totalPenjualan.value) {
            totalPenjualan.value = totalPenjualan.value.replace(/\./g, '');
        }
        
        if (totalKeuntungan.value) {
            totalKeuntungan.value = totalKeuntungan.value.replace(/\./g, '');
        }
    });
</script>
@endpush
@endsection
