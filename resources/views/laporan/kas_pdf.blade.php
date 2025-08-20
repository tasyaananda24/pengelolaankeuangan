<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Kas - TPQ ASAAFA</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p.subtext {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td:last-child,
        th:last-child {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
            font-size: 12px;
        }

        .summary p {
            margin: 4px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <p><strong>YAYASAN KESEJAHTERAAN ISLAM ASAAFA</strong></p>
        <p><strong>TPQ ASAAFA</strong></p>
        <p>Kep Menhumham No AHU-0016323.AH.01.04</p>
        <p>Jln Karya Bhakti No.01 RT 20 RW 14 Sukamelang, Subang</p>
    </div>

    <h2>Laporan Keuangan Kas</h2>
    <p class="subtext">
        Periode: {{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->translatedFormat('F') }} {{ $tahun }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jenis Transaksi</th>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $t->jenis === 'debit' ? 'Masuk' : 'Keluar' }}</td>
                    <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalKredit, 0, ',', '.') }}</p>
        <p><strong>Saldo Akhir:</strong> Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
    </div>

</body>
</html>
