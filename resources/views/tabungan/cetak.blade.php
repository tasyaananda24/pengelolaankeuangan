<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tabungan - {{ $santri->nama }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr.total {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .total-label {
            text-align: right;
        }
    </style>
</head>
<body>

    <h1>Laporan Tabungan<br>{{ $santri->nama }}</h1>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSetoran = 0;
                $totalPenarikan = 0;
            @endphp
            @foreach ($santri->tabungans as $tabungan)
                @php
                    if ($tabungan->jenis === 'setoran') {
                        $totalSetoran += $tabungan->jumlah;
                    } elseif ($tabungan->jenis === 'penarikan') {
                        $totalPenarikan += $tabungan->jumlah;
                    }
                @endphp
                <tr>
                    <td>{{ $tabungan->tanggal }}</td>
                    <td>{{ ucfirst($tabungan->jenis) }}</td>
                    <td>Rp {{ number_format($tabungan->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $tabungan->keterangan }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="2" class="total-label">Total Setoran</td>
                <td colspan="2">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="2" class="total-label">Total Penarikan</td>
                <td colspan="2">Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="2" class="total-label">Saldo Akhir</td>
                <td colspan="2">Rp {{ number_format($totalSetoran - $totalPenarikan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
