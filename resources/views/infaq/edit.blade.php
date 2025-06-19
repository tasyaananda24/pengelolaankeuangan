@extends('theme.default')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Edit Infaq Bulanan Santri</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('infaq.update', $infaq->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-row align-items-end">
                    {{-- Santri --}}
                    <div class="col-md-3 mb-3">
                        <label>Santri</label>
                        <select class="form-control" name="santri_id" required>
                            <option value="">Pilih Santri</option>
                            @foreach($santris as $santri)
                                <option value="{{ $santri->id }}" {{ $infaq->santri_id == $santri->id ? 'selected' : '' }}>
                                    {{ $santri->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bulan --}}
                    <div class="col-md-2 mb-3">
                        <label>Bulan</label>
                        <input type="text" class="form-control" name="bulan" value="{{ $infaq->bulan }}" required>
                    </div>

                    {{-- Tanggal Bayar --}}
                    <div class="col-md-2 mb-3">
                        <label>Tanggal Bayar</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $infaq->tanggal }}" required>
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-md-2 mb-3">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" value="{{ $infaq->jumlah }}" required>
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-md-3 mb-3">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="{{ $infaq->keterangan }}">
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('infaq.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
