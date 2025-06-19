@extends('themeketua.default')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Laporan Infaq Bulanan Santri</h1>

    <form method="GET" action="{{ route('laporan.infaq') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="month" name="bulan" class="form-control" value="{{ request()->get('bulan', date('Y-m')) }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">Tampilkan</button>
        </div>
    </form>
    <div class="mb-3">
    <a href="{{ route('infaq.export', request()->query()) }}" class="btn btn-outline-success">
        <i class="fas fa-file-download"></i> Unduh Laporan PDF
    </a>
</div>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Bulan: <strong>{{ $bulanSelected }}</strong></h5>
            <h5>Total Infaq: <span class="text-success">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</span></h5>

            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>Jumlah Infaq</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data infaq pada bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
