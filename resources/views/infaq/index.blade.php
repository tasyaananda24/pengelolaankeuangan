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
            <input type="text" name="search" id="search" class="form-control"
                   value="{{ request()->get('search') }}" placeholder="Contoh: Ahmad">
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

   {{-- Tombol Form Setting --}}
<div class="mb-3">
    <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#form-setting-infaq" aria-expanded="false" aria-controls="form-setting-infaq">
        + Setting Infaq Bulanan
    </button>
</div>

{{-- Form Setting Infaq --}}
<div class="collapse card shadow-sm mb-4" id="form-setting-infaq">
    <div class="card-header bg-light"><strong>Form Setting Infaq Bulanan</strong></div>
    <div class="card-body">
        <form action="{{ route('infaq.setting.store') }}" method="POST" class="row" id="formSettingInfaq">
            @csrf
            <div class="form-group col-md-4">
                <label for="bulan">Bulan & Tahun</label>
                <input type="month" id="bulan" name="bulan" class="form-control" required>
                <div id="errorBulan" class="invalid-feedback" style="display:none;">
                    Bulan ini sudah pernah disetting. Silakan pilih bulan lain.
                </div>
            </div>
            <div class="form-group col-md-4">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
            </div>
            <div class="form-group col-12">
                <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan Setting</button>
            </div>
        </form>
    </div>
</div>

@php
    $bulanTerpakai = $settingInfaq->map(fn($item) => \Carbon\Carbon::parse($item->bulan)->format('Y-m'))->toArray();
@endphp

<script>
    const bulanTerpakai = @json($bulanTerpakai);
    const inputBulan = document.getElementById('bulan');
    const errorBulan = document.getElementById('errorBulan');
    const btnSubmit = document.getElementById('btnSubmit');

    inputBulan.addEventListener('input', function () {
        const val = this.value;
        if (bulanTerpakai.includes(val)) {
            this.classList.add('is-invalid');
            errorBulan.style.display = 'block';
            btnSubmit.disabled = true;
        } else {
            this.classList.remove('is-invalid');
            errorBulan.style.display = 'none';
            btnSubmit.disabled = false;
        }
    });
</script>

{{-- Script validasi bulan tidak ganda --}}
<script>
    const bulanTerpakai = @json($bulanTerpakai);
    const inputBulan = document.getElementById('bulan');
    const errorBulan = document.getElementById('errorBulan');
    const btnSubmit = document.getElementById('btnSubmit');

    inputBulan.addEventListener('input', function () {
        const val = this.value;
        if (bulanTerpakai.includes(val)) {
            this.classList.add('is-invalid');
            errorBulan.style.display = 'block';
            btnSubmit.disabled = true;
        } else {
            this.classList.remove('is-invalid');
            errorBulan.style.display = 'none';
            btnSubmit.disabled = false;
        }
    });
</script>


    {{-- Tabel Setting Infaq --}}
    @if($settingInfaq && $settingInfaq->count())
        <div class="mb-4">
            <h5 class="mb-3">Jumlah Bayar Infaq</h5>
            <div class="row g-3">
                @foreach($settingInfaq as $setting)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="card-title mb-1">
                                        {{ \Carbon\Carbon::parse($setting->bulan)->translatedFormat('F Y') }}
                                    </h6>
                                    <p class="card-text mb-1">
                                        <strong>Jumlah:</strong> Rp {{ number_format($setting->jumlah, 0, ',', '.') }}
                                    </p>
                                    <p class="card-text text-muted mb-2">
                                        <small>{{ $setting->keterangan ?? 'Tidak ada keterangan' }}</small>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <form action="{{ route('infaq.setting.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus setting bulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Tabel Rekapitulasi --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light"><strong>Rekap Infaq Bulanan Tahun {{ $tahunDipilih }}</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Santri</th>
                        @foreach($bulanUnik as $blnKey)
                            <th class="text-center">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $blnKey)->translatedFormat('F') }}
                            </th>
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
                    $pembayaran = $santri->infaq->firstWhere('bulan', $blnKey);
                    $bulanFormatted = \Carbon\Carbon::createFromFormat('Y-m', $blnKey)->translatedFormat('F Y');
                    $bulanDatetime = \Carbon\Carbon::createFromFormat('Y-m', $blnKey)->startOfMonth();
                    $tanggalDaftar = \Carbon\Carbon::parse($santri->created_at)->startOfMonth();
                @endphp

                <td class="text-center">
                    @if($bulanDatetime < $tanggalDaftar)
                        <span class="text-muted"><em>Tidak Wajib</em></span>
                    @elseif($pembayaran)
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
                <a href="{{ route('infaq.download', ['santri' => $santri->id, 'tahun' => $tahunDipilih]) }}" target="_blank" class="btn btn-sm btn-warning mb-1">
                    <i class="fas fa-table"></i> Detail
                </a><br>
                <a href="{{ route('infaq.download.pdf', ['santri' => $santri->id, 'tahun' => $tahunDipilih]) }}" target="_blank" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf"></i> PDF
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
