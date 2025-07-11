@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-gradient-admin mb-2" style="font-size:2.5rem; letter-spacing:1px;">Dashboard Admin</h2>
        <p class="lead text-admin-dark">Pantau, kelola, dan distribusikan dana investasi dengan mudah dan profesional.</p>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#investorListModal">
                <div class="card border-0 shadow-lg rounded-4 bg-gradient-admin text-white text-center animate__animated animate__fadeInUp card-hover">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-1 mb-2"></i>
                        <h4 class="fw-bold">{{ $totalInvestor ?? 0 }}</h4>
                        <div>Investor</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#umkmListModal">
                <div class="card border-0 shadow-lg rounded-4 bg-gradient-admin2 text-white text-center animate__animated animate__fadeInUp card-hover">
                    <div class="card-body">
                        <i class="bi bi-shop-window fs-1 mb-2"></i>
                        <h4 class="fw-bold">{{ $totalUmkm ?? 0 }}</h4>
                        <div>UMKM Terdaftar</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg rounded-4 bg-gradient-admin3 text-white text-center animate__animated animate__fadeInUp">
                <div class="card-body">
                    <i class="bi bi-cash-coin fs-1 mb-2"></i>
                    <h4 class="fw-bold">Rp {{ number_format($totalDana ?? 0, 0, ',', '.') }}</h4>
                    <div>Total Dana Terkumpul</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg rounded-4 bg-gradient-admin4 text-white text-center animate__animated animate__fadeInUp">
                <div class="card-body">
                    <i class="bi bi-graph-up-arrow fs-1 mb-2"></i>
                    <h4 class="fw-bold">{{ $totalTransaksi ?? 0 }}</h4>
                    <div>Total Transaksi</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <a href="{{ route('admin.laporan.index') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 gradient-card h-100 d-flex flex-column align-items-center justify-content-center position-relative">
                    <div class="position-absolute top-0 end-0 m-2">
                        @php
                            $pendingLaporan = \App\Models\LaporanPenjualan::where('status', 'pending')->count();
                        @endphp
                        @if($pendingLaporan > 0)
                            <span class="badge bg-warning text-dark">{{ $pendingLaporan }}</span>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-bar-graph display-4 text-gradient"></i>
                        <h5 class="fw-bold mt-2 mb-0">Laporan Penjualan</h5>
                        <div class="text-muted small">Verifikasi & Riwayat</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- Modal Daftar UMKM Terdaftar -->
    <div class="modal fade" id="umkmListModal" tabindex="-1" aria-labelledby="umkmListModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="umkmListModalLabel">Daftar UMKM Terdaftar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tanggal Gabung</th>
                  <th>Dana Dibutuhkan</th>
                  <th>Durasi Investasi</th>
                  <th>Investor yang Berinvestasi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($umkms as $i => $umkm)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $umkm->nama }}</td>
                  <td>{{ $umkm->created_at ? $umkm->created_at->format('d M Y') : '-' }}</td>
                  <td>Rp{{ number_format($umkm->dana_dibutuhkan, 0, ',', '.') }}</td>
                  <td>{{ $umkm->durasi_investasi ?? '-' }}</td>
                  <td>{{ $umkm->transaksis()->where('jenis','investasi')->distinct('user_id')->count('user_id') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Daftar Investor Terdaftar -->
    <div class="modal fade" id="investorListModal" tabindex="-1" aria-labelledby="investorListModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="investorListModalLabel">Daftar Investor Terdaftar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tanggal Gabung</th>
                  <th>Jumlah Dana Diinvestasi</th>
                  <th>Jumlah UMKM Diinvestasi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($investors as $i => $investor)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $investor->name }}</td>
                  <td>{{ $investor->created_at ? $investor->created_at->format('d M Y') : '-' }}</td>
                  <td>Rp{{ number_format($investor->jumlah_dana, 0, ',', '.') }}</td>
                  <td>{{ $investor->jumlah_umkm }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
@push('scripts')
<style>
.text-gradient-admin {
    background: linear-gradient(90deg, #283e51 0%, #485563 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
}
.bg-gradient-admin {
    background: linear-gradient(135deg, #283e51 0%, #485563 100%);
}
.bg-gradient-admin2 {
    background: linear-gradient(135deg, #7b4397 0%, #dc2430 100%);
}
.bg-gradient-admin3 {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.bg-gradient-admin4 {
    background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
}
.btn-gradient-admin {
    background: linear-gradient(90deg, #283e51 0%, #485563 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.btn-gradient-admin:hover {
    box-shadow: 0 4px 16px 0 #283e5155;
    transform: translateY(-2px) scale(1.04);
    color: #fff;
}
.text-admin-dark {
    color: #283e51;
}
.card-hover {
    transition: transform 0.2s;
}
.card-hover:hover {
    transform: translateY(-5px);
}
</style>
@endpush
@endsection
