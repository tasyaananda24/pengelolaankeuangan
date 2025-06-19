@extends('themeketua.default')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4 text-gray-800">Laporan Keuangan Kas</h1>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('kas.laporan') }}" class="form-inline mb-3">
        <div class="form-group mr-2">
            <label class="mr-2">Bulan</label>
            <select name="bulan" class="form-control">
                <option value="">-- Semua Bulan --</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mr-2">
            <label class="mr-2">Tahun</label>
            <select name="tahun" class="form-control">
                <option value="">-- Semua Tahun --</option>
                @for ($y = 2025; $y <= 2040; $y++)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        @if($transaksi->count() > 0)
        <a href="{{ route('kas.laporan.cetak', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" class="btn btn-success ml-2" target="_blank">
            <i class="fas fa-download"></i> Unduh PDF
        </a>
        @endif
    </form>

    <!-- Tabel -->
    @if($transaksi->count() > 0)
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Transaksi</th>
                        <th>Keterangan</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($item->jenis_transaksi) }}</td>
                        <td class="text-left">{{ $item->keterangan }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $item->jenis == 'kredit' ? 'success' : 'danger' }}">{{ ucfirst($item->jenis) }}</span>
                        </td>
                        <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="4" class="text-right">Total Kredit</td>
                        <td class="text-right text-success">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td colspan="4" class="text-right">Total Debit</td>
                        <td class="text-right text-danger">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="font-weight-bold bg-light">
                        <td colspan="4" class="text-right">Saldo Akhir</td>
                        <td class="text-right text-primary">Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info">Tidak ada data transaksi untuk periode ini.</div>
    @endif
</div>
@endsection
