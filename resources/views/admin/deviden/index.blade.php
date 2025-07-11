@extends('layouts.app')
@section('title', 'Jadwal Pembagian Deviden')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Jadwal Pembagian Deviden UMKM</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>UMKM</th>
                        <th>Jadwal Bagi</th>
                        <th>Total Keuntungan</th>
                        <th>Fee Admin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $i => $schedule)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $schedule->umkm->nama ?? '-' }}</td>
                        <td>{{ $schedule->jadwal_bagi }}</td>
                        <td>Rp{{ number_format($schedule->total_keuntungan,0,',','.') }}</td>
                        <td>Rp{{ number_format($schedule->fee_admin,0,',','.') }}</td>
                        <td>
                            @if($schedule->is_distributed)
                                <span class="badge bg-success">Sudah Dibagikan</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                        <td>
                            @if(!$schedule->is_distributed)
                            <form method="POST" action="{{ route('admin.deviden.distribute', $schedule->id) }}" class="d-inline">
                                @csrf
                                <input type="number" name="total_keuntungan" class="form-control form-control-sm mb-1" placeholder="Total Keuntungan" required min="1">
                                <button type="submit" class="btn btn-sm btn-gradient-primary">Bagikan</button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-outline-secondary" disabled>Bagikan</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
