<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Keuangan Kas</h2>
    <p align="center">
        Periode: {{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->translatedFormat('F') }} {{ $tahun }}
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
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $t->jenis === 'debit' ? 'Masuk' : 'Keluar' }}</td>
                    <td>{{ $t->jenis_transaksi }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
    <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalKredit, 0, ',', '.') }}</p>
    <p><strong>Saldo Akhir:</strong> Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
</body>
</html>
