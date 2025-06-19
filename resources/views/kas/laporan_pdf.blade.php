<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Kas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td {
            text-align: center;
        }
        td.keterangan {
            text-align: left;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
        .summary {
            margin-top: 30px;
        }
        .summary p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <h2>Laporan Keuangan Kas</h2>
    <p style="text-align: center;">
        Periode: {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') ?? 'Semua Bulan' }} {{ $tahun ?? '' }}
    </p>

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
            @forelse($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($t->jenis) }}</td>
                    <td>{{ $t->jenis_transaksi }}</td>
                    <td class="keterangan">{{ $t->keterangan }}</td>
                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalKredit, 0, ',', '.') }}</p>
        <p><strong>Saldo Akhir:</strong> Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</p>
    </div>

</body>
</html>
