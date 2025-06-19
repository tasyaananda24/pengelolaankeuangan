@extends('theme.default')

@section('content')
<div class="container">
    <h2>Infaq Santri Bulan {{ $bulan }}</h2>
    <p>Jumlah yang harus dibayar per santri: <strong>Rp {{ number_format($setting->jumlah, 0, ',', '.') }}</strong></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Santri</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($santris as $santri)
                <tr>
                    <td>{{ $santri->nama }}</td>
                    <td>{{ $santri->infaq_status ? 'Lunas' : 'Belum Bayar' }}</td>
                    <td>{{ $santri->infaq_tanggal ? \Carbon\Carbon::parse($santri->infaq_tanggal)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if ($santri->infaq_status)
                            <form method="POST" action="{{ route('infaq.batal', $santri->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                                <button class="btn btn-warning">Batalkan</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('infaq.bayar', $santri->id) }}">
                                @csrf
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                                <button class="btn btn-success">Sudah Bayar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
