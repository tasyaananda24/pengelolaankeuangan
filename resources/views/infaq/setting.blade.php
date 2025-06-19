@extends('theme.default')

@section('content')
<div class="container">
    <h2>Setting Infaq Bulanan</h2>
    <form action="{{ route('infaq.setting.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" placeholder="Contoh: Juni 2025" required>
        </div>

        <div class="mb-3">
            <label>Jumlah Infaq per Santri</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 20000" required>
        </div>

        <div class="mb-3">
            <label>Keterangan (opsional)</label>
            <input type="text" name="keterangan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Setting</button>
    </form>
</div>
@endsection
