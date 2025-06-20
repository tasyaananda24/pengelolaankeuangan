@extends('themeketua.default')

@section('content')
<div class="container-fluid">

    {{-- Judul Halaman --}}
    <div class="mb-4">
        <h4 class="fw-bold text-dark">
            <i class="fas fa-chart-line text-success me-2"></i> Laporan Infaq Tahunan
        </h4>
        <hr>
    </div>

    {{-- Form Filter Tahun --}}
    <form method="GET" action="{{ route('laporan.infaq') }}" class="card p-4 shadow-sm border-0 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="tahun" class="form-label text-muted">Pilih Tahun</label>
                <select name="tahun" id="tahun" class="form-select form-select-lg shadow-sm">
                    @for($thn = 2025; $thn <= 2040; $thn++)
                        <option value="{{ $thn }}" {{ $thn == $tahun ? 'selected' : '' }}>{{ $thn }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>

            <div class="col-md-3">
                <a href="{{ route('laporan.infaq.pdf', ['tahun' => $tahun]) }}" target="_blank" class="btn btn-outline-success btn-lg w-100 shadow-sm">
                    <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                </a>
            </div>
        </div>
    </form>

    {{-- Tabel Rekap Infaq --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <strong><i class="fas fa-calendar-alt me-2"></i> Rekapitulasi Infaq Tahun {{ $tahun }}</strong>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-light text-center text-secondary fw-semibold">
                        <tr>
                            <th style="width: 60%;">Bulan</th>
                            <th style="width: 40%;">Total Infaq (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bulanNama = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                        @endphp
                        @foreach($bulanNama as $num => $nama)
                            @php
                                $key = $tahun . '-' . $num;
                                $total = $infaqPerBulan[$key] ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $nama }}</td>
                                <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-light fw-bold">
                            <td class="text-end">Total Keseluruhan</td>
                            <td class="text-end">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
