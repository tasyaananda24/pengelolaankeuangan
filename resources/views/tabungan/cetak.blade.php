<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tabungan - {{ $santri->nama }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background-color: #ffffff;
            color: #333;
            font-size: 13px;
        }

        /* Kop Surat */
        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .kop p {
            margin: 2px 0;
            font-size: 13px;
        }

        .line {
            border-bottom: 2px solid #000;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        h1.title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 0;
            color: #007bff;
        }

        h2.nama-santri {
            text-align: center;
            font-size: 18px;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr.total {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .total-label {
            text-align: right;
        }

        /* Footer */
        .ttd {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }

        .ttd .content {
            width: 250px;
        }
    </style>
</head>
<body>

    {{-- Kop Surat --}}
    <div class="kop">
        <h2>TPQ ASAAFA</h2>
        <h2>YAYASAN KESEJAHTERAAN ISLAM ASAFA</h2>
        <p>No AHU-0016323.AH.01.04 | Jln Karya Bhakti No.01 RT 20 RW 14, Sukamelang, Subang</p>
    </div>
    <div class="line"></div>

    {{-- Judul --}}
    <h1 class="title">Laporan Tabungan Santri</h1>
    <h2 class="nama-santri">{{ $santri->nama }}</h2>

    {{-- Tabel Tabungan --}}
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
                    <td>{{ \Carbon\Carbon::parse($tabungan->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($tabungan->jenis) }}</td>
                    <td>Rp {{ number_format($tabungan->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $tabungan->keterangan ?? '-' }}</td>
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
