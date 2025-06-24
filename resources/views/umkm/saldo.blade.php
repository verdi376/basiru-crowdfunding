@extends('layouts.app')
@section('title', 'Saldo UMKM')
@section('content')
<div class="container my-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-wallet2 me-2"></i>Saldo UMKM</h3>
    <div class="row justify-content-start">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Total Saldo</h5>
                    <div class="display-5 fw-bold text-success mb-2">
                        Rp 0
                    </div>
                    <span class="text-muted small">Saldo aktif dapat digunakan untuk transaksi</span>
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#topUpModal">
                            <i class="bi bi-plus-circle me-1"></i> Top Up
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tarikModal">
                            <i class="bi bi-arrow-down-circle me-1"></i> Tarik Saldo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Transaksi Saldo Masuk/Keluar
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Tipe</th>
                                <th scope="col" class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <div class="mb-2"><i class="bi bi-inbox fs-3"></i></div>
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="alert alert-info mt-4" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                Saldo UMKM adalah dana yang dapat digunakan untuk kebutuhan usaha, seperti pembelian bahan baku, pembayaran operasional, dan lainnya. Riwayat transaksi akan muncul di sini setiap kali ada pemasukan atau pengeluaran saldo.
            </div>
        </div>
    </div>
</div>

{{-- Modal Top Up --}}
<div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="topUpModalLabel"><i class="bi bi-plus-circle me-2 text-primary"></i>Top Up Saldo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="topup-amount" class="form-label">Nominal Top Up</label>
            <input type="number" class="form-control" id="topup-amount" placeholder="Masukkan nominal" min="10000">
          </div>
          <button type="submit" class="btn btn-primary w-100" disabled>Proses Top Up</button>
        </form>
        <div class="text-muted small mt-2">*Fitur ini belum aktif.</div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Tarik Saldo --}}
<div class="modal fade" id="tarikModal" tabindex="-1" aria-labelledby="tarikModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tarikModalLabel"><i class="bi bi-arrow-down-circle me-2 text-danger"></i>Tarik Saldo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="tarik-amount" class="form-label">Nominal Penarikan</label>
            <input type="number" class="form-control" id="tarik-amount" placeholder="Masukkan nominal" min="10000">
          </div>
          <button type="submit" class="btn btn-danger w-100" disabled>Proses Penarikan</button>
        </form>
        <div class="text-muted small mt-2">*Fitur ini belum aktif.</div>
      </div>
    </div>
  </div>
</div>
@endsection
