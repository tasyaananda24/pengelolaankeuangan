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

        @php
            // Ambil semua bulan yang sudah disetting
            $bulanTerpakai = $settingInfaq->map(fn($item) => \Carbon\Carbon::parse($item->bulan)->format('Y-m'))->toArray();

            // Cari bulan paling akhir yang sudah disetting untuk jadi batas minimum
            $minBulan = count($bulanTerpakai) > 0 ? max($bulanTerpakai) : null;

            // Bulan maksimal adalah akhir tahun ini (Desember)
         $maxBulan = '2040-12';

        @endphp

        <form action="{{ route('infaq.setting.store') }}" method="POST" class="row" id="formSettingInfaq">
            @csrf
            <div class="form-group col-md-4">
                <label for="bulan">Bulan & Tahun</label>
                <input
                    type="month"
                    id="bulan"
                    name="bulan"
                    class="form-control"
                    required
                    @if($minBulan) min="{{ $minBulan }}" @endif
                    max="{{ $maxBulan }}"
                >
                <div id="errorBulan" class="invalid-feedback" style="display:none;">
                    Bulan ini sudah pernah disetting. Silakan pilih bulan lain.
                </div>
            </div>

            <div class="form-group col-md-4">
                <label>Nominal Bayar</label>
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

{{-- JavaScript untuk validasi jika user memilih bulan yang sudah pernah disetting --}}
<script>
    const bulanTerpakai = @json($bulanTerpakai);
    const inputBulan = document.getElementById('bulan');
    const errorBulan = document.getElementById('errorBulan');
    const btnSubmit = document.getElementById('btnSubmit');

    inputBulan.addEventListener('input', function () {
        const val = this.value.substring(0, 7); // Ambil format YYYY-MM saja
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
        <div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3 text-success">Jumlah Bayar Infaq</h5>

        @forelse($settingInfaq as $setting)
            <div class="d-flex justify-content-between align-items-start flex-wrap py-2 border-bottom">
                <div class="me-3">
                    <div class="fw-bold">
                        {{ \Carbon\Carbon::parse($setting->bulan)->translatedFormat('F Y') }}
                    </div>
                    <div>Jumlah: <strong>Rp {{ number_format($setting->jumlah, 0, ',', '.') }}</strong></div>
                    <div class="text-muted"><small>{{ $setting->keterangan ?? 'Tidak ada keterangan' }}</small></div>
                </div>
                <form action="{{ route('infaq.setting.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus setting bulan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        @empty
            <p class="text-muted">Belum ada data setting infaq.</p>
        @endforelse
    </div>
</div>

    

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
