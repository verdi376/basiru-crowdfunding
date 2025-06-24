@extends('layouts.app')

@section('title', 'Edit Profil UMKM')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold">Edit Profil UMKM</h2>
    <form action="{{ route('umkm.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('umkm.form', ['umkm' => $umkm])

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
