@extends('theme.default')

@section('content')
@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div class="container-fluid">
    <h1 class="h4 mb-4">Laporan Infaq Bulanan Santri - Ketua Yayasan</h1>

    {{-- Filter Tahun --}}
    <form method="GET" action="{{ route('infaq.laporan.ketua') }}" class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                @foreach($tahunList as $thn)
                    <option value="{{ $thn }}" {{ $thn == $tahunDipilih ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-header bg-light"><strong>Rekap Infaq Tahun {{ $tahunDipilih }}</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nama Santri</th>
                        @foreach($bulanUnik as $blnKey)
                            <th class="text-center">{{ \Carbon\Carbon::createFromFormat('Y-m', $blnKey)->translatedFormat('M') }}</th>
                        @endforeach
                        <th class="text-center">Jumlah Bayar</th>
                        <th class="text-center">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($santris as $santri)
                        @php
                            $jumlahBayar = 0;
                            $totalInfaq = 0;
                        @endphp
                        <tr>
                            <td>{{ $santri->nama }}</td>
                            @foreach($bulanUnik as $blnKey)
                                @php
                                    $pembayaran = $santri->infaq->firstWhere('bulan', $blnKey);
                                    $setting = $settingInfaq->firstWhere('bulan', $blnKey);
                                @endphp
                                <td class="text-center">
                                    @if($pembayaran)
                                        <span class="badge bg-success">✔</span>
                                        @php
                                            $jumlahBayar++;
                                            $totalInfaq += $setting->jumlah ?? 0;
                                        @endphp
                                    @else
                                        <span class="badge bg-danger">✘</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-center">{{ $jumlahBayar }} bulan</td>
                            <td class="text-end">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
