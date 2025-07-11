@extends('layouts.app')

@section('title', 'Edit Portofolio')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Edit Portofolio</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('portofolios.update', $portofolio->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('portofolios._form', ['portofolio' => $portofolio])

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('portofolios.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
