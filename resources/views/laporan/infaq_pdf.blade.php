<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Infaq Tahunan {{ $tahun }}</h2>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Infaq (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulanNama as $num => $nama)
                @php
                    $key = $tahun . '-' . $num;
                    $total = $infaqPerBulan[$key] ?? 0;
                @endphp
                <tr>
                    <td>{{ $nama }}</td>
                    <td style="text-align:right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align:right"><strong>Total Keseluruhan</strong></td>
                <td style="text-align:right"><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
