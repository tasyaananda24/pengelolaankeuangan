@extends('themeketua.default') {{-- Ganti dengan layout yang digunakan untuk ketua --}}

@section('content')
<div class="container">
    <h1>Profil Saya (Ketua Yayasan)</h1>

    <div class="mb-3">
        <label class="form-label">Nama:</label>
        <div class="form-control-plaintext">{{ $user->name }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <div class="form-control-plaintext">{{ $user->email }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Password:</label>
        <div class="form-control-plaintext">******** <small class="text-muted">(disembunyikan)</small></div>
    </div>

    <a href="{{ route('profileketua.edit') }}" class="btn btn-warning">Edit Profil</a>

    <a href="{{ route('profileketua.password') }}" class="btn btn-secondary">Ubah Password</a>
</div>
@endsection
