<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Infaq {{ $santri->nama }} - {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #eee; }
        h2, h4 { margin: 0; padding: 0; }
    </style>
</head>
<body>

    <h2>Rekapitulasi Infaq Santri</h2>
    <h4>Tahun: {{ $tahun }}</h4>
    <br>
    <p><strong>Nama Santri:</strong> {{ $santri->nama }}</p>
    <p><strong>Alamat:</strong> {{ $santri->alamat ?? '-' }}</p>

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
            @php
                use Carbon\Carbon;
                Carbon::setLocale('id');
            @endphp
            @for($i = 1; $i <= 12; $i++)
                @php
                    $bulan = Carbon::create($tahun, $i, 1);
                    $bulanFormat = $bulan->format('Y-m');
                    $pembayaran = $infaqs->first(fn($item) => Carbon::parse($item->tanggal)->format('Y-m') === $bulanFormat);
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $bulan->translatedFormat('F Y') }}</td>
                    @if($pembayaran)
                        <td style="color: green;">Sudah Bayar</td>
                        <td>{{ Carbon::parse($pembayaran->tanggal)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                    @else
                        <td style="color: red;">Belum Bayar</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>

    <p style="margin-top: 30px;">Dicetak pada: {{ now()->translatedFormat('d F Y') }}</p>

</body>
</html>
