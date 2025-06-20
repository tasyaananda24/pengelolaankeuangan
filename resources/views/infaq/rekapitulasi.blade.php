<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Infaq {{ $santri->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #eee; }
        .belum { color: red; }
        .sudah { color: green; }
    </style>
</head>
<body>

    <h2>Rekapitulasi Infaq Santri</h2>
    <p><strong>Tahun:</strong> {{ $tahun }}</p>
    <p><strong>Nama Santri:</strong> {{ $santri->nama }}</p>
    <p><strong>Alamat:</strong> {{ $santri->alamat }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulanUnik as $i => $bulan)
                @php
                    $pembayaran = $santri->infaq->firstWhere('bulan', $bulan);
                    $bulanText = \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $bulanText }}</td>
                    <td class="{{ $pembayaran ? 'sudah' : 'belum' }}">
                        {{ $pembayaran ? 'Sudah Bayar' : 'Belum Bayar' }}
                    </td>
                    <td>
                        {{ $pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal)->format('d M Y') : '-' }}
                    </td>
                    <td>
                        {{ $pembayaran ? 'Rp ' . number_format($pembayaran->jumlah, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

</body>
</html>
