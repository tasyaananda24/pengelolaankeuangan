@extends('theme.default')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Kas</h1>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    <!-- Saldo Kas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Saldo Kas</h6>
        </div>
        <div class="card-body">
            <h2 class="text-success">Rp {{ number_format(abs($saldo), 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="row mb-4">
        <div class="col-md-3">
            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#tambahKreditModal">
                <i class="fas fa-plus-circle"></i> Tambah Kredit
            </button>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#tambahDebitModal">
    <i class="fas fa-donate"></i> Input Donasi
</button>

        </div>
    </div>

    <!-- Form Pencarian Bulan dan Tahun -->
<form method="GET" action="{{ url('/kas') }}" class="form-inline mb-3">
    <div class="form-group mr-2">
        <label for="bulan" class="mr-2">Bulan</label>
        <select name="bulan" id="bulan" class="form-control">
            <option value="">-- Semua Bulan --</option>
            @foreach (range(1, 12) as $m)
                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" 
                    {{ request('bulan') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mr-2">
    <label for="jenis" class="mr-2">Jenis</label>
    <select name="jenis" id="jenis" class="form-control">
        <option value="">-- Semua Jenis --</option>
        <option value="kredit" {{ request('jenis') == 'kredit' ? 'selected' : '' }}>Kredit</option>
        <option value="debit" {{ request('jenis') == 'debit' ? 'selected' : '' }}>Debit</option>
    </select>
</div>

    <div class="form-group mr-2">
        <label for="tahun" class="mr-2">Tahun</label>
        @php
            $years = range(2025, 2040);  // rentang tahun yang diinginkan
        @endphp
        <select name="tahun" id="tahun" class="form-control">
            <option value="">-- Semua Tahun --</option>
            @foreach ($years as $year)
                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ url('/kas') }}" class="btn btn-secondary ml-2">Reset</a>
</form>

    <!-- Tabel Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Riwayat Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @foreach ($transaksi as $bulan => $items)
                    <h5 class="text-success mt-4">
                        {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                    </h5>
                    <table class="table table-bordered table-striped table-hover mb-4">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Transaksi</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($item->tanggal)) }}</td>
                                <td>{{ ucfirst($item->jenis_transaksi) }}</td>
                                <td class="text-left">{{ $item->keterangan }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->jenis == 'kredit' ? 'success' : 'danger' }}">
                                        {{ ucfirst($item->jenis) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#editModal{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('kas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah Kredit -->
<div class="modal fade" id="tambahKreditModal" tabindex="-1" role="dialog" aria-labelledby="tambahKreditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahKreditModalLabel">Tambah Kredit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formTambahKredit" action="{{ url('/kas/kredit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="pilihan_kredit">Jenis Pengeluaran</label>
                        <select name="pilihan" id="pilihan_kredit" class="form-control" required>
                            <option value="" disabled selected hidden>Pilih Jenis</option>
                            <option value="honor">Honor</option>
                            <option value="atk">ATK</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Misalnya: Beli alat tulis" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukkan nominal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

   

<!-- Modal Tambah Debit -->
<div class="modal fade" id="tambahDebitModal" tabindex="-1" role="dialog" aria-labelledby="tambahDebitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Debit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('/kas/debit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                       <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="pilihan">Jenis Pemasukan</label>
                        <select name="pilihan" id="pilihan" class="form-control" required>
                            <option value="" disabled selected hidden></option>
                            <option value="donasi">Donasi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach ($transaksi as $bulan => $items)
    @foreach ($items as $item)
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ url('/kas/update/'.$item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $item->keterangan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control" required>
                                <option value="kredit" {{ $item->jenis == 'kredit' ? 'selected' : '' }}>Kredit</option>
                                <option value="debit" {{ $item->jenis == 'debit' ? 'selected' : '' }}>Debit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

@endsection

@section('scripts')

@endsection

@section('styles')
<style>
    /* Styling header tabel */
    table thead.thead-light th {
        background-color: #d4edda; /* hijau muda */
        color: #155724; /* hijau tua */
        font-weight: 600;
        text-align: center;
    }

    /* Center align semua isi td dan th kecuali keterangan */
    table.table tbody tr td,
    table.table tbody tr th {
        vertical-align: middle;
        text-align: center;
    }

    /* Keterangan rata kiri */
    table.table tbody tr td:nth-child(3) {
        text-align: left;
    }

    /* Hover efek baris */
    table.table tbody tr:hover {
        background-color: #f1fdf1;
        cursor: pointer;
    }

    /* Tombol aksi rapikan */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }
</style>
@endsection
