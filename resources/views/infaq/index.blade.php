@extends('theme.default')

@section('content')
@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div class="container-fluid">
    <h1 class="h4 mb-4">Rekap Infaq Bulanan Santri</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Pencarian & Filter Tahun --}}
    <form action="{{ route('infaq.index') }}" method="GET" class="row mb-3 g-2 align-items-end">
        <div class="col-md-6">
            <label for="search">Cari Nama Santri</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Contoh: Ahmad">
        </div>
        <div class="col-md-3">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                @foreach($tahunList as $thn)
                    <option value="{{ $thn }}" {{ $thn == $tahunDipilih ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Tombol Tampilkan Form Setting --}}
    <div class="mb-3">
        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#form-setting-infaq" aria-expanded="false" aria-controls="form-setting-infaq">
            + Setting Infaq Bulanan
        </button>
    </div>

    {{-- Form Setting Jumlah Infaq Bulanan --}}
    <div id="form-setting-infaq" class="collapse card shadow-sm mb-4">
        <div class="card-header bg-light"><strong>Form Setting Infaq Bulanan</strong></div>
        <div class="card-body">
            <form action="{{ route('infaq.setting.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label>Bulan</label>
                    <input type="month" name="bulan" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Simpan Setting</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Setting Infaq --}}
@if($settingInfaq && $settingInfaq->count())
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light"><strong>Daftar Setting Infaq</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr class="text-center">
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($settingInfaq as $index => $setting)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($setting->bulan)->translatedFormat('F Y') }}</td>
                        <td>Rp {{ number_format($setting->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $setting->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('infaq.setting.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus setting bulan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif


    {{-- Tabel Rekap Infaq --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light"><strong>Rekap Infaq Bulanan Tahun {{ $tahunDipilih }}</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Santri</th>
                        @foreach($bulanLabel as $label)
                            <th class="text-center">{{ $label }}</th>
                        @endforeach
                        <th class="text-center">Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($santris as $santri)
                        <tr>
                            <td>{{ $santri->nama }}</td>
                            @foreach($bulanUnik as $blnKey)
                                @php
                                    $pembayaran = $santri->infaq->firstWhere(fn($i) => \Carbon\Carbon::parse($i->tanggal)->format('Y-m') === $blnKey);
                                    $bulanFormatted = \Carbon\Carbon::createFromFormat('Y-m', $blnKey)->translatedFormat('F Y');
                                @endphp
                                <td class="text-center">
                                    @if($pembayaran)
                                        <span class="badge bg-success">Sudah Bayar</span><br>
                                        <small>{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d M Y') }}</small>
                                        <form action="{{ route('infaq.batal', $pembayaran->id) }}" method="POST" class="mt-1">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-secondary" onclick="return confirm('Batalkan pembayaran ini?')">Batal</button>
                                        </form>
                                    @else
                                        <form action="{{ route('infaq.bayar', $santri->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="bulan" value="{{ $blnKey }}">
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Tandai sudah bayar untuk {{ $santri->nama }} bulan {{ $bulanFormatted }}?')">Belum Bayar</button>
                                        </form>
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-center">
                                <a href="{{ route('infaq.download', ['santri' => $santri->id, 'tahun' => $tahunDipilih]) }}" target="_blank" class="btn btn-sm btn-warning">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
