@extends('layouts.app')

@section('title', 'Tambah Portofolio')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tambah Portofolio</h2>

    <form action="{{ route('portofolios.store') }}" method="POST">
        @csrf

        @include('portofolios._form', ['portofolio' => null])

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('portofolios.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
