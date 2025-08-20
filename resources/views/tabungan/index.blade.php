@extends('theme.default')

@section('content')
<div class="container-fluid">
    <h3>Kelola Tabungan Santri</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ===================== Form Setoran dan Penarikan ===================== --}}
    <div class="card mb-4 w-100">
        <div class="card-body">
            {{-- Form Tambah Setoran --}}
            {{-- Form Tambah Setoran --}}
        <h5 class="mb-3 text-primary">Form Tambah Setoran</h5>
        <form action="{{ route('tabungan.setoran') }}" method="POST" class="form-row align-items-end mb-3">
                @csrf
                <div class="col-md-2">
                    <label>Santri</label>
                    <select name="santri_id" class="form-control" id="selectSantriSetoran" required>
                        <option value="">Pilih Santri</option>
                        @foreach($santris as $santri)
                            <option value="{{ $santri->id }}" data-kode="{{ $santri->kode_santri }}">{{ $santri->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label>Kode</label>
                    <input type="text" id="kodeSantriSetoran" class="form-control" placeholder="Kode" readonly>
                </div>
                <div class="col-md-2">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                </div>
                <div class="col-md-2">
                    <label>Nominal</label>
                    <input type="text" class="form-control format-rupiah" placeholder="Nominal" required>
                    <input type="hidden" name="jumlah" class="jumlah-asli">
                </div>
                <div class="col-md-3">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block mt-4">Tambah Setoran</button>
                </div>
            </form>

            {{-- Form Tambah Penarikan --}}
            <h5 class="mb-3 text-primary">Form Penarikan</h5>
            <form action="{{ route('tabungan.penarikan') }}" method="POST" class="form-row align-items-end">
                @csrf
                <div class="col-md-2">
                    <label>Santri</label>
                    <select name="santri_id" class="form-control" id="selectSantriPenarikan" required>
                        <option value="">Pilih Santri</option>
                        @foreach($santris as $santri)
                            @php
                                $setoran = $santri->tabungans->where('jenis', 'setoran')->sum('jumlah');
                                $penarikan = $santri->tabungans->where('jenis', 'penarikan')->sum('jumlah');
                                $saldo = $setoran - $penarikan;
                            @endphp
                            <option value="{{ $santri->id }}" data-kode="{{ $santri->kode_santri }}" data-saldo="{{ $saldo }}">
                                {{ $santri->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label>Kode</label>
                    <input type="text" id="kodeSantriPenarikan" class="form-control" placeholder="Kode" readonly>
                </div>
                <div class="col-md-2">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                </div>
                <div class="col-md-2">
                    <label>Nominal</label>
                    <input type="text" class="form-control format-rupiah" placeholder="Nominal" required>
                    <input type="hidden" name="jumlah" class="jumlah-asli">
                </div>
                <div class="col-md-3">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-warning btn-block mt-4">Tambah Penarikan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== Tabel Saldo ===================== --}}
    <div class="card mb-4">
        <div class="card-header">Daftar Saldo Tabungan Santri</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Santri</th>
                        <th>Saldo</th>
                        <th>Setoran Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalSaldo = 0; @endphp
                    @foreach ($santris as $santri)
                        @php
                            $setoran = $santri->tabungans->where('jenis', 'setoran')->sum('jumlah');
                            $penarikan = $santri->tabungans->where('jenis', 'penarikan')->sum('jumlah');
                            $saldo = $setoran - $penarikan;
                            $totalSaldo += $saldo;
                            $lastSetoran = $santri->tabungans->where('jenis', 'setoran')->sortByDesc('tanggal')->first();
                        @endphp
                        <tr>
                            <td>{{ $santri->nama }}</td>
                            <td>Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                            <td>{{ optional($lastSetoran)->tanggal ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="showDetail({{ $santri->id }}, '{{ $santri->nama }}')">Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <h5>Total Saldo:
                    <span id="totalSaldo" class="font-weight-bold text-success">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </span>
                </h5>
            </div>
        </div>
    </div>

    {{-- ===================== Modal Detail ===================== --}}
    <div class="modal fade" id="detailTabunganModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tabungan <span id="namaSantri"></span></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-row align-items-end mb-3">
                        <div class="col-md-4">
                            <label>Bulan</label>
                            <select class="form-control" id="modalFilterBulan">
                                <option value="">Semua</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tahun</label>
                            <select class="form-control" id="modalFilterTahun">
                                <option value="">Semua</option>
                                @for ($i = 2025; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button class="btn btn-primary mt-4" onclick="applyFilter()">Cari</button>
                        </div>
                    </div>
                    <table class="table table-bordered" id="detailTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="mt-3 text-right">
                        <h5>Total Tabungan:
                            <span id="totalTabunganSantri" class="text-primary">Rp 0</span>
                        </h5>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="#" target="_blank" class="btn btn-secondary" id="btnCetak">Cetak PDF</a>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Transaksi -->
<div class="modal fade" id="editTransaksiModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="formEditTransaksi">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editId">
          <div class="form-group">
            <label>Nominal</label>
            <input type="text" class="form-control format-rupiah" id="editJumlah" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" class="form-control" id="editKeterangan" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    $('.format-rupiah').on('keyup', function () {
        let nilai = $(this).val();
        let cleanNumber = nilai.replace(/\D/g, '');
        $(this).val('Rp ' + formatRupiah(nilai));
        $(this).siblings('.jumlah-asli').val(cleanNumber);
    });

let currentSantriId = null;

function showDetail(santriId, nama) {
    currentSantriId = santriId;
    $('#namaSantri').text(nama);
    $('#modalFilterBulan').val('');
    $('#modalFilterTahun').val('');
    loadTabunganDetail(santriId);
    $('#detailTabunganModal').modal('show');
}

function applyFilter() {
    const bulan = $('#modalFilterBulan').val();
    const tahun = $('#modalFilterTahun').val();
    loadTabunganDetail(currentSantriId, bulan, tahun);
}

function loadTabunganDetail(santriId, bulan = '', tahun = '') {
    $('#detailTable tbody').empty();
    $('#totalTabunganSantri').text('Rp 0');
    const baseUrl = window.location.origin;
    const cetakUrl = `${baseUrl}/tabungan/cetak/${santriId}?bulan=${bulan}&tahun=${tahun}`;
    $('#btnCetak').attr('href', cetakUrl);

    $.get(`/tabungan/detail/${santriId}?bulan=${bulan}&tahun=${tahun}`, function(res) {
        if (res.success) {
            let total = 0;
            res.data.forEach(item => {
                let jumlah = parseInt(item.jumlah) || 0;
                if (item.jenis === 'setoran') total += jumlah;
                else if (item.jenis === 'penarikan') total -= jumlah;

                let jenisBadge = item.jenis === 'setoran'
                    ? '<span class="badge badge-success">Setoran</span>'
                    : '<span class="badge badge-danger">Penarikan</span>';

                let row = `
                    <tr>
                        <td>${item.tanggal}</td>
                        <td>${jenisBadge}</td>
                        <td>Rp ${jumlah.toLocaleString('id-ID')}</td>
                        <td>${item.keterangan ?? '-'}</td>
                        <td><button class="btn btn-warning btn-sm" onclick="editTransaksi(${item.id})">Edit</button></td>
                    </tr>`;
                $('#detailTable tbody').append(row);
            });
            $('#totalTabunganSantri').text('Rp ' + total.toLocaleString('id-ID'));
        }
    });
}
// Isi otomatis kode santri saat dipilih di form setoran
$('#selectSantriSetoran').on('change', function () {
    const selectedOption = $(this).find('option:selected');
    $('#kodeSantriSetoran').val(selectedOption.data('kode') || '');
});

// Isi otomatis kode santri saat dipilih di form penarikan
$('#selectSantriPenarikan').on('change', function () {
    const selectedOption = $(this).find('option:selected');
    $('#kodeSantriPenarikan').val(selectedOption.data('kode') || '');
});
function editTransaksi(id) {
    $.get(`/tabungan/transaksi/${id}`, function(res) {
        if (res.success) {
            $('#editId').val(res.data.id);
            $('#editJumlah').val(formatRupiah(res.data.jumlah.toString()));
            $('#editKeterangan').val(res.data.keterangan);
            $('#editTransaksiModal').modal('show');
        }
    });
}

// Submit form edit
$('#formEditTransaksi').on('submit', function (e) {
    e.preventDefault();

    let id = $('#editId').val();
    let jumlah = $('#editJumlah').val().replace(/\D/g, '');
    let keterangan = $('#editKeterangan').val();

    $.ajax({
        url: `/tabungan/transaksi/${id}`,
        method: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            jumlah: jumlah,
            keterangan: keterangan
        },
        success: function (res) {
            if (res.success) {
                $('#editTransaksiModal').modal('hide');
                loadTabunganDetail(currentSantriId); // reload detail
            } else {
                alert('Gagal memperbarui data');
            }
        }
    });
});

</script>
@endsection
