@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Verifikasi Laporan Penjualan UMKM</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>UMKM</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->umkm->nama ?? '-' }}</td>
                        <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <span class="badge bg-{{ $laporan->status == 'diterima' ? 'success' : ($laporan->status == 'ditolak' ? 'danger' : 'warning') }}">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </td>
                        <td>{{ $laporan->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.download', $laporan->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                            <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#verifModal{{ $laporan->id }}">
                                <i class="bi bi-check2-square"></i> Verifikasi
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Verifikasi -->
                    <div class="modal fade" id="verifModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="verifModalLabel{{ $laporan->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.laporan.verifikasi', $laporan->id) }}" class="modal-content">
                          @csrf
                          <div class="modal-header">
                            <h5 class="modal-title" id="verifModalLabel{{ $laporan->id }}">Verifikasi Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <textarea name="keterangan" class="form-control" rows="2"></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-gradient-primary">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada laporan penjualan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
