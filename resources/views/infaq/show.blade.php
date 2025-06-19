@extends('theme.default')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Detail Infaq Santri</h1>

    {{-- Informasi Santri --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-2">Nama Santri: <strong>{{ $santri->nama }}</strong></h5>
            <p class="mb-1">Jumlah Transaksi: <strong>{{ $infaqs->count() }}</strong></p>
            <p>Total Infaq: <strong>Rp {{ number_format($infaqs->sum('jumlah'), 0, ',', '.') }}</strong></p>
        </div>
    </div>

    {{-- Tabel Transaksi Infaq --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Riwayat Transaksi Infaq</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($infaqs as $index => $infaq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $infaq->bulan }}</td>
                                <td>{{ \Carbon\Carbon::parse($infaq->tanggal)->format('d-m-Y') }}</td>
                                <td>Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $infaq->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada transaksi infaq</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('infaq.index') }}" class="btn btn-secondary mt-4">← Kembali</a>
        </div>
    </div>
</div>
@endsection
