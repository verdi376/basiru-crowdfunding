@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transaksi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h5>Transaksi Baru</h5>
            <form method="POST" action="{{ route('investor.transaksi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="jenis" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="donasi">Donasi</option>
                            <option value="topup">Top-up Saldo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah (Rp)" required>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="bukti" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h5>Riwayat Transaksi</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ ucfirst($transaksi->jenis) }}</td>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaksi->status) }}</td>
                    <td>
                        @if ($transaksi->bukti)
                            <a href="{{ asset('storage/' . $transaksi->bukti) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
