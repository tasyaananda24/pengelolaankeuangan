@extends('theme.default') {{-- Layout utama yang kamu gunakan --}}

@section('content')
<div class="container">
    <h1>Profil Saya</h1>

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

    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profil</a>

    <a href="{{ route('profile.password') }}" class="btn btn-secondary">Ubah Password</a>


</div>
@endsection
