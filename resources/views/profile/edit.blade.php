@extends('theme.default') {{-- Atau layout yang Anda gunakan --}}

@section('content')
<div class="container">
    <h1>Edit Profil</h1>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        {{-- Tambahkan field lain sesuai kebutuhan --}}

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
