@extends('layouts.app')
@include('layouts.partials.umkm-laporan-css')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Laporan Penjualan</h2>
        <button class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-upload"></i> Upload PDF
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="mb-3">
        <input type="text" class="form-control" id="searchLaporan" placeholder="Cari tanggal/status...">
    </div>
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <table class="table table-hover align-middle" id="laporanTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <span class="badge bg-{{ $laporan->status == 'diterima' ? 'success' : ($laporan->status == 'ditolak' ? 'danger' : 'warning') }}">
                                {{ ucfirst($laporan->status) }}
                            </span>
                            @if($laporan->keterangan)
                            <span class="badge bg-info">{{ $laporan->keterangan }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('umkm.laporan.download', $laporan->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#previewModal{{ $laporan->id }}"><i class="bi bi-eye"></i> Preview</button>
                        </td>
                    </tr>
                    <!-- Modal Preview PDF -->
                    <div class="modal fade" id="previewModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="previewModalLabel{{ $laporan->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel{{ $laporan->id }}">Preview Laporan Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <iframe src="{{ asset(str_replace('public/', 'storage/', $laporan->file_path)) }}" width="100%" height="500px" style="border:none;"></iframe>
                          </div>
                        </div>
                      </div>
                    </div>
                    @empty
                    <tr><td colspan="4" class="text-center">Belum ada laporan penjualan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Grafik penjualan (opsional, jika ada data) -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h5 class="mb-3">Grafik Penjualan (Coming Soon)</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
</div>
<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('umkm.laporan.store') }}" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalLabel">Upload Laporan Penjualan (PDF)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="file" name="pdf" accept="application/pdf" class="form-control mb-3" required>
        <div class="form-text">Maksimal 20MB. Format PDF.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-gradient-primary">Upload</button>
      </div>
    </form>
  </div>
</div>
<!-- Chart.js (opsional, jika ingin grafik dinamis) -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dummy chart, ganti dengan data dinamis jika ada
const ctx = document.getElementById('salesChart');
if(ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Penjualan',
                data: [120, 190, 300, 500, 200, 300],
                borderColor: '#4f8cff',
                backgroundColor: 'rgba(79,140,255,0.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}

// Filter/search laporan penjualan
const searchInput = document.getElementById('searchLaporan');
const table = document.getElementById('laporanTable');
if(searchInput && table) {
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        for (let row of table.tBodies[0].rows) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        }
    });
}
</script>
@endpush
@endsection
