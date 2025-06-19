<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tabungan - {{ $santri->nama }}</title>
</head>
<body>
    <h1>Laporan Tabungan - {{ $santri->nama }}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($santri->tabungans as $tabungan)
                <tr>
                    <td>{{ $tabungan->tanggal }}</td>
                    <td>{{ ucfirst($tabungan->jenis) }}</td>
                    <td>Rp {{ number_format($tabungan->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $tabungan->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
