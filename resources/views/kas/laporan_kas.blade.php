@extends('themeketua.default')

@section('content')
<style>
    .laporan-container {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f9fbfc;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    h2 {
        text-align: center;
        color: #198754;
        margin-bottom: 25px;
        font-size: 24px;
    }

    .filter-form {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter-form select,
    .filter-form button {
        padding: 8px 14px;
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .filter-form button {
        background-color: #198754;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .filter-form button:hover {
        background-color: #146c43;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background-color: #fff;
    }

    th, td {
        padding: 12px 10px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    th {
        background-color: #e0f2f1;
        color: #004d40;
        font-weight: bold;
    }

    td.keterangan {
        text-align: left;
    }

    tbody tr:hover {
        background-color: #f1fdf7;
    }

    .periode-info {
        text-align: center;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .export-form {
        text-align: center;
        margin-bottom: 20px;
    }

    .export-form button {
        padding: 8px 14px;
        font-size: 14px;
        background-color:  #198754;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .export-form button:hover {
        background-color: #157347;
    }

    .summary {
        margin-top: 30px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
        background-color: #ecfdf5;
        padding: 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        color: #065f46;
        box-shadow: inset 0 0 4px rgba(0,0,0,0.03);
    }

    .summary-item {
        flex: 1 1 30%;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .summary-item::before {
        content: '💰';
        font-size: 20px;
    }

    @media (max-width: 600px) {
        .summary {
            flex-direction: column;
            align-items: center;
        }

        .summary-item {
            justify-content: center;
        }
    }
</style>

@php
    $selectedBulan = (int) request('bulan', date('n'));
    $selectedTahun = (int) request('tahun', date('Y'));
@endphp

<div class="laporan-container">
    <h2>Laporan Keuangan Kas</h2>

    {{-- Filter Form --}}
    <form action="{{ route('kas.laporan') }}" method="GET" class="filter-form">
        <select name="bulan">
            @foreach(range(1, 12) as $b)
                <option value="{{ $b }}" {{ $b == $selectedBulan ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::createFromDate(null, $b, 1)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>

        <select name="tahun">
            @for($y = 2025; $y <= 2040; $y++)
                <option value="{{ $y }}" {{ $y == $selectedTahun ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        <button type="submit">🔍 Tampilkan</button>
    </form>

    {{-- Export Button --}}
    <form action="{{ route('kas.export') }}" method="GET" class="export-form">
    <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
    <input type="hidden" name="tahun" value="{{ $selectedTahun }}">
    <button type="submit">📄 Unduh Laporan PDF</button>
</form>


    {{-- Periode --}}
    <p class="periode-info">
        Periode: {{ \Carbon\Carbon::create()->month($selectedBulan)->translatedFormat('F') }} {{ $selectedTahun }}
    </p>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jenis Transaksi</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDebit = 0;
                $totalKredit = 0;
            @endphp
            @forelse($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $t->jenis === 'debit' ? 'Masuk' : 'Keluar' }}</td>
                    <td>{{ $t->jenis_transaksi }}</td>
                    <td class="keterangan">{{ $t->keterangan }}</td>
                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
                @php
                    if ($t->jenis === 'debit') {
                        $totalDebit += $t->jumlah;
                    } elseif ($t->jenis === 'kredit') {
                        $totalKredit += $t->jumlah;
                    }
                @endphp
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Ringkasan --}}
    <div class="summary">
        <div class="summary-item">Total Pemasukan: Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
        <div class="summary-item">Total Pengeluaran: Rp {{ number_format($totalKredit, 0, ',', '.') }}</div>
        <div class="summary-item">Saldo Akhir: Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</div>
    </div>
</div>
@endsection
