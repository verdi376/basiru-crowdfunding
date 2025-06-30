@extends('layouts.app')

@section('title', 'Buat Profil UMKM')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 animate__animated animate__fadeInUp rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h2 class="fw-bold mb-0">🚀 Buat Profil UMKM</h2>
                    <small>Lengkapi informasi berikut untuk memperkenalkan UMKM kamu kepada publik</small>
                </div>

                <div class="card-body p-4">
                    {{-- ⬇ Mulai Form --}}
                    <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        {{-- ✅ Dana Dibutuhkan --}}
                        <div class="mb-3">
                            <label for="dana_dibutuhkan" class="form-label">
                                Dana Dibutuhkan (Rp)
                            </label>
                            <input type="number" name="dana_dibutuhkan" id="dana_dibutuhkan"
                                   class="form-control @error('dana_dibutuhkan') is-invalid @enderror"
                                   value="{{ old('dana_dibutuhkan') }}" min="1000" required>

                            @error('dana_dibutuhkan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                Jumlah minimal Rp 1.000. UMKM tanpa dana tidak akan ditampilkan.
                            </div>
                        </div>

                        {{-- ⬇ Field-field lainnya --}}
                        @include('umkm.form')

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save2"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                    {{-- ⬆ Selesai Form --}}
                </div>

                <div class="card-footer bg-light text-center rounded-bottom-4">
                    <small class="text-muted"><i class="bi bi-info-circle"></i> Pastikan data yang diisi sudah benar sebelum menyimpan.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
