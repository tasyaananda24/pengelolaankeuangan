@extends('theme.default')

@section('content')
<div class="container">
    <h2>Tambah Infaq Santri</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan pada input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('infaq.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="santri_id" class="form-label">Nama Santri</label>
            <select name="santri_id" id="santri_id" class="form-control" required>
                <option value="">-- Pilih Santri --</option>
                @foreach ($santris as $santri)
                    <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" placeholder="Contoh: Mei 2025" value="{{ old('bulan') }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Infaq</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah (contoh: 20000)" value="{{ old('jumlah') }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Opsional" value="{{ old('keterangan') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('infaq.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
