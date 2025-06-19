@extends('themeketua.default') {{-- Ganti sesuai layout ketua yayasan --}}

@section('content')
<div class="container">
    <h1>Edit Profil (Ketua Yayasan)</h1>
    
    <form action="{{ route('profileketua.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        {{-- Tambahkan field lain jika dibutuhkan, misalnya nomor hp, alamat, dsb --}}

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('profileketua.show') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
