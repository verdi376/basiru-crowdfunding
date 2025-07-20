@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Laporan Penjualan</h5>
                    <a href="{{ route('umkm.laporan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Laporan
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($laporans->isEmpty())
                        <div class="alert alert-info">
                            Belum ada laporan penjualan. Silakan tambahkan laporan baru.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Periode</th>
                                        <th>Total Penjualan</th>
                                        <th>Total Keuntungan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laporans as $index => $laporan)
                                        <tr>
                                            <td>{{ $laporans->firstItem() + $index }}</td>
                                            <td>{{ $laporan->judul }}</td>
                                            <td>
                                                {{ $laporan->periode_awal->format('d M Y') }} - 
                                                {{ $laporan->periode_akhir->format('d M Y') }}
                                            </td>
                                            <td>Rp {{ number_format($laporan->total_penjualan, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($laporan->total_keuntungan, 0, ',', '.') }}</td>
                                            <td>
                                                @if($laporan->status == 'menunggu')
                                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                @elseif($laporan->status == 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    @if($laporan->catatan_admin)
                                                        <br><small class="text-muted">{{ $laporan->catatan_admin }}</small>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('umkm.laporan.show', $laporan->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($laporan->status == 'menunggu')
                                                        <a href="{{ route('umkm.laporan.edit', $laporan->id) }}" 
                                                           class="btn btn-sm btn-warning"
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('umkm.laporan.destroy', $laporan->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <a href="{{ Storage::url($laporan->file) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       target="_blank"
                                                       title="Unduh File">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $laporans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
