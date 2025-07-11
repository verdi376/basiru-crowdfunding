@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transaksi</h3>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            💸 {{ session('error') }}
            <a href="{{ route('investor.saldo') }}" class="alert-link">Top-up di sini</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Form Transaksi Baru --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Transaksi Baru</h5>
            <form method="POST" action="{{ route('investor.transaksi.store') }}">
                @csrf
                <div class="row g-3">
                    <input type="hidden" name="jenis" value="investasi"> {{-- Jenis default --}}
                    
                    <div class="col-md-3">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah (Rp)" required>
                    </div>
                    
                    <div class="col-md-5">
                        <select name="umkm_id" class="form-select" required>
                            <option value="">Pilih UMKM</option>
                            @foreach($umkms as $umkm)
                                <option value="{{ $umkm->id }}" {{ isset($selectedUmkmId) && $selectedUmkmId == $umkm->id ? 'selected' : '' }}>
                                    {{ $umkm->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Riwayat --}}
    <h5>Riwayat Transaksi</h5>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Sisa Saldo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $i => $transaksi)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                      @if($transaksi->jenis === 'topup')
                        Setor
                      @elseif($transaksi->jenis === 'tarik')
                        Tarik
                      @elseif($transaksi->jenis === 'investasi')
                        Investasi
                      @else
                        {{ ucfirst($transaksi->jenis) }}
                      @endif
                    </td>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->sisa_saldo ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaksi->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
