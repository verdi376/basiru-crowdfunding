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
                    <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

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
                </div>
                <div class="card-footer bg-light text-center rounded-bottom-4">
                    <small class="text-muted"><i class="bi bi-info-circle"></i> Pastikan data yang diisi sudah benar sebelum menyimpan.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
