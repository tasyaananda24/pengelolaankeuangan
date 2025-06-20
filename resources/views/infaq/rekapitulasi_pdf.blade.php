<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Infaq {{ $santri->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        .belum { color: red; }
        .sudah { color: green; }
        .kop p { margin: 2px 0; }
        .line { border-bottom: 2px solid #000; margin-top: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>

    {{-- Kop Surat --}}
    <table width="100%">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo YKIA" width="70">
            </td>
            <td width="85%" align="center" class="kop">
                <h3 style="margin: 0;">YAYASAN KESEJAHTERAAN ISLAM ASAFA</h3>
                <p>Kep Menhumham No AHU-0016323.AH.01.04</p>
                <p><strong>Tahun {{ $tahun }}</strong></p>
                <p>Jln Karya Bhakti no.01 RT 20 RW 14 Sukamelang, Subang</p>
            </td>
        </tr>
    </table>
    <div class="line"></div>

    {{-- Judul --}}
    <h3 style="text-align: center; margin-top: 10px;">Rekapitulasi Infaq Santri</h3>
    <p><strong>Nama Santri:</strong> {{ $santri->nama }}</p>
    <p><strong>Alamat:</strong> {{ $santri->alamat }}</p>

    {{-- Tabel --}}
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
                    <td>{{ $pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal)->format('d M Y') : '-' }}</td>
                    <td>{{ $pembayaran ? 'Rp ' . number_format($pembayaran->jumlah, 0, ',', '.') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

</body>
</html>
