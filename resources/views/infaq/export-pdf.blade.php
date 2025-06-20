<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Infaq Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Rekap Infaq Bulanan Santri</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Santri</th>
                @foreach($bulanLabel as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($santris as $santri)
                <tr>
                    <td style="text-align: left;">{{ $santri->nama }}</td>
                    @foreach($bulanUnik as $blnKey)
                        @php
                            $start = \Carbon\Carbon::parse($blnKey)->startOfMonth();
                            $end = \Carbon\Carbon::parse($blnKey)->endOfMonth();
                            $pembayaran = $santri->infaq->first(function($i) use ($start, $end) {
                                return $i->tanggal >= $start && $i->tanggal <= $end;
                            });
                        @endphp
                        <td>
                            @if($pembayaran)
                                Sudah<br>{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d/m/Y') }}
                            @else
                                Belum
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
