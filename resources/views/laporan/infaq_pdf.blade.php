<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Infaq Tahunan - TPQ ASAAFA</title>
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
            margin: 0 0 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td:last-child, th:last-child {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <p><strong>YAYASAN KESEJAHTERAAN ISLAM ASAAFA</strong></p>
          <p><strong>TPQ ASAAFA</strong></p>
        <p>Kep Menhumham No AHU-0016323.AH.01.04</p>
        <p>Jln Karya Bhakti no.01 RT 20 RW 14 Sukamelang, Subang</p>
    </div>

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
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align:right"><strong>Total Keseluruhan</strong></td>
                <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
