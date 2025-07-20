@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Laporan Penjualan</h5>
                    <a href="{{ route('umkm.laporan.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informasi Umum</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Judul Laporan:</strong><br> {{ $laporan->judul }}</p>
                                <p><strong>Periode:</strong><br>
                                    {{ $laporan->periode_awal->format('d F Y') }} - {{ $laporan->periode_akhir->format('d F Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong><br>
                                    @if($laporan->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @elseif($laporan->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </p>
                                <p><strong>Tanggal Dilaporkan:</strong><br>
                                    {{ $laporan->created_at->format('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Rincian Keuangan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Total Penjualan</h6>
                                        <h4 class="text-primary">Rp {{ number_format($laporan->total_penjualan, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Total Keuntungan</h6>
                                        <h4 class="text-success">Rp {{ number_format($laporan->total_keuntungan, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($laporan->keterangan)
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Keterangan Tambahan</h5>
                            <p class="mb-0">{{ $laporan->keterangan }}</p>
                        </div>
                    @endif

                    @if($laporan->status == 'ditolak' && $laporan->catatan_admin)
                        <div class="alert alert-warning">
                            <h5 class="alert-heading">Catatan Admin</h5>
                            <p class="mb-0">{{ $laporan->catatan_admin }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h5 class="border-bottom pb-2">Dokumen Pendukung</h5>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf fa-2x text-danger me-2"></i>
                            <div class="flex-grow-1">
                                <p class="mb-0">{{ basename($laporan->file) }}</p>
                                <small class="text-muted">
                                    {{ Storage::size('public/' . $laporan->file) / 1024 }} KB
                                </small>
                            </div>
                            <a href="{{ asset('storage/' . $laporan->file) }}" 
                               class="btn btn-sm btn-primary" 
                               target="_blank"
                               download>
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        </div>
                    </div>

                    @if($laporan->status == 'menunggu')
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('umkm.laporan.edit', $laporan->id) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Laporan
                            </a>
                            <form action="{{ route('umkm.laporan.destroy', $laporan->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus Laporan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
