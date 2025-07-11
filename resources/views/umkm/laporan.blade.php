@extends('layouts.app')

@section('title', 'Laporan Penjualan UMKM')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg rounded-4 mb-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-gradient-umkm">Upload Laporan Penjualan</h4>
                    <form action="{{ route('umkm.laporan.store') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
                        @csrf
                        <input type="file" name="laporan_pdf" accept="application/pdf" class="form-control" required>
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan/Periode (misal: Juni 2025)">
                        <button class="btn btn-gradient-umkm" type="submit"><i class="bi bi-upload"></i> Upload</button>
                    </form>
                </div>
            </div>
            <div class="card shadow-lg rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-gradient-umkm">Daftar Laporan Penjualan</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $laporan)
                            <tr>
                                <td>{{ $laporan->keterangan }}</td>
                                <td><a href="{{ asset('storage/'.$laporan->file) }}" target="_blank"><i class="bi bi-file-earmark-pdf text-danger"></i> PDF</a></td>
                                <td><span class="badge {{ $laporan->status == 'terverifikasi' ? 'bg-success' : 'bg-warning' }}">{{ ucfirst($laporan->status) }}</span></td>
                                <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ asset('storage/'.$laporan->file) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="bi bi-download"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada laporan penjualan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<style>
.text-gradient-umkm {
    background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
}
.btn-gradient-umkm {
    background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.btn-gradient-umkm:hover {
    box-shadow: 0 4px 16px 0 #11998e55;
    transform: translateY(-2px) scale(1.04);
    color: #fff;
}
</style>
@endpush
@endsection
