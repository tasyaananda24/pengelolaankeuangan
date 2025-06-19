@extends('theme.default')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Detail Infaq: {{ $santri->nama }}</h4>

    <a href="{{ route('infaq.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Bulan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($santri->infaq as $infaq)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($infaq->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($infaq->bulan . '-01')->translatedFormat('F Y') }}</td>
                    <td>Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $infaq->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data infaq</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
