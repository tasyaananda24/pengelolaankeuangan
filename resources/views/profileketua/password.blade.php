@extends('themeketua.default')

@section('content')
<div class="container">
    <h1>Ubah Password</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profileketua.password') }}" method="POST">
        @csrf

        {{-- Password Saat Ini --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">Password Saat Ini</label>
            <div class="input-group">
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                       id="current_password" name="current_password" required>
                <span class="input-group-text">
                    <i class="toggle-password bi bi-eye" data-target="current_password" style="cursor:pointer"></i>
                </span>
            </div>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                <span class="input-group-text">
                    <i class="toggle-password bi bi-eye" data-target="password" style="cursor:pointer"></i>
                </span>
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" required>
                <span class="input-group-text">
                    <i class="toggle-password bi bi-eye" data-target="password_confirmation" style="cursor:pointer"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
        <a href="{{ route('profileketua.show') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- Script toggle password --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
</script>

{{-- Bootstrap Icons CDN --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
