<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Santri - TPQ ASAAFA</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
            padding: 2px;
        }

        p {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 11px;
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
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

        .badge-aktif {
            color: #fff;
            background-color: #28a745;
            padding: 3px 8px;
            border-radius: 5px;
            font-weight: bold;
        }

        .badge-nonaktif {
            color: #fff;
            background-color: #6c757d;
            padding: 3px 8px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>LAPORAN DATA SANTRI</h2>
    <h4>TPQ ASAAFA</h4>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Nama Orang Tua</th>
                <th>No. HP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($santris as $index => $santri)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $santri->nama }}</td>
                    <td>{{ $santri->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    <td>{{ $santri->alamat }}</td>
                    <td>{{ $santri->nama_ortu }}</td>
                    <td>{{ $santri->no_hp }}</td>
                    <td class="text-center">
                        @if(strtolower($santri->status) === 'aktif')
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data santri.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
