@extends('theme.default')

@section('content')
<div class="container">
    <h3>Kelola Tabungan Santri</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            {{-- Form Setoran --}}
            <form action="{{ route('tabungan.setoran') }}" method="POST" class="mb-3">
                @csrf
                <h5>Tambah Setoran</h5>
                <div class="form-row">
                    <div class="col-md-3">
                        <select name="santri_id" class="form-control" required>
                            <option value="">Pilih Santri</option>
                            @foreach($santris as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                       <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-block">Tambah Setoran</button>
                    </div>
                </div>
            </form>

            {{-- Form Penarikan --}}
            <form action="{{ route('tabungan.penarikan') }}" method="POST">
                @csrf
                <h5>Tambah Penarikan</h5>
                <div class="form-row">
                    <div class="col-md-3">
                        <select name="santri_id" class="form-control" required>
                            <option value="">Pilih Santri</option>
                            @foreach($santris as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                       <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning btn-block">Tambah Penarikan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
       {{-- Tabel Saldo --}}
<div class="card">
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
                        $lastSetoran = $santri->tabungans
                            ->where('jenis', 'setoran')
                            ->sortByDesc('tanggal')
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $santri->nama }}</td>
                        <td>Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                        <td>{{ optional($lastSetoran)->tanggal ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="showDetail({{ $santri->id }}, '{{ $santri->nama }}')">Detail</button>
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


{{-- Modal Detail --}}
<div class="modal fade" id="detailTabunganModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tabungan <span id="namaSantri"></span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
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

                {{-- Total Saldo --}}
                <div class="mt-3 text-right">
                    <h5>Total Tabungan: 
                        <span id="totalTabunganSantri" class="text-primary">Rp 0</span>
                    </h5>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="#" target="_blank" class="btn btn-secondary" id="btnCetak">Cetak PDF</a>
                    <a href="#" target="_blank" class="btn btn-success" id="btnWhatsapp">Kirim via WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Edit --}}
<div class="modal fade" id="editTransaksiModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editTransaksiForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" id="editTanggal">
                    </div>
                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" id="editJenis">
                            <option value="setoran">Setoran</option>
                            <option value="penarikan">Penarikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="editJumlah">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" id="editKeterangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showDetail(santriId, nama) {
    $('#namaSantri').text(nama);
    $('#detailTable tbody').empty();
    $('#totalTabunganSantri').text('Rp 0'); // Reset tampilan total

    // Set link cetak dan WhatsApp
    $('#btnCetak').attr('href', `/tabungan/cetak/${santriId}`);
    
    const namaEncoded = encodeURIComponent(nama);
const link = `${window.location.origin}/tabungan/cetak/${santriId}`;
const pesan = `Assalamualaikum, berikut laporan tabungan santri *${nama}*:\nSilakan buka: ${link}`;
const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(pesan)}`;
$('#btnWhatsapp').attr('href', whatsappUrl);


    // Ambil data tabungan santri via AJAX
    $.get(`/tabungan/detail/${santriId}`, function(res) {
        if (res.success) {
            let total = 0;

            res.data.forEach(item => {
                let jumlah = parseInt(item.jumlah) || 0;

                // Hitung saldo total
                if (item.jenis === 'setoran') {
                    total += jumlah;
                } else if (item.jenis === 'penarikan') {
                    total -= jumlah;
                }

                // Buat row tabel
                let jenisBadge = item.jenis === 'setoran' ?
                    '<span class="badge badge-success">Setoran</span>' :
                    '<span class="badge badge-danger">Penarikan</span>';

                let row = `
                    <tr>
                        <td>${item.tanggal}</td>
                        <td>${jenisBadge}</td>
                        <td>Rp ${jumlah.toLocaleString('id-ID')}</td>
                        <td>${item.keterangan ?? '-'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editTransaksi(${item.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="hapusTransaksi(${item.id})">Hapus</button>
                        </td>
                    </tr>`;
                $('#detailTable tbody').append(row);
            });

            // Tampilkan total tabungan
            $('#totalTabunganSantri').text('Rp ' + total.toLocaleString('id-ID'));

            // Tampilkan modal
            $('#detailTabunganModal').modal('show');
        }
    });
}

function showDetail(santriId, nama) {
    $('#namaSantri').text(nama);
    $('#detailTable tbody').empty();
    $('#totalTabunganSantri').text('Rp 0');

    const baseUrl = window.location.origin;
    const cetakUrl = `${baseUrl}/tabungan/cetak/${santriId}`;

    // Format pesan WhatsApp dengan link dapat diklik
    const pesan = `Assalamualaikum, berikut laporan tabungan santri *${nama}*. Silakan buka tautan berikut:\n${cetakUrl}`;
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(pesan)}`;

    // Set link tombol
    $('#btnCetak').attr('href', cetakUrl);
    $('#btnWhatsapp').attr('href', whatsappUrl);

    // Ambil data tabungan via AJAX
    $.get(`/tabungan/detail/${santriId}`, function(res) {
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
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editTransaksi(${item.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="hapusTransaksi(${item.id})">Hapus</button>
                        </td>
                    </tr>`;
                $('#detailTable tbody').append(row);
            });

            // Tampilkan total saldo
            $('#totalTabunganSantri').text('Rp ' + total.toLocaleString('id-ID'));

            // Tampilkan modal detail
            $('#detailTabunganModal').modal('show');
        }
    });
}


function editTransaksi(id) {
    $.get(`/tabungan/transaksi/${id}`, function(res) {
        if (res.success) {
            $('#editId').val(res.data.id);
            $('#editTanggal').val(res.data.tanggal);
            $('#editJenis').val(res.data.jenis);
            $('#editJumlah').val(res.data.jumlah);
            $('#editKeterangan').val(res.data.keterangan);
            $('#editTransaksiModal').modal('show');
        } else {
            alert('Data tidak ditemukan');
        }
    });
}

$('#editTransaksiForm').submit(function(e) {
    e.preventDefault();
    const id = $('#editId').val();
    $.ajax({
        url: `/tabungan/edit/${id}`,
        type: 'PUT',
        data: $(this).serialize(),
        success: function(res) {
            if (res.success) {
                alert('Transaksi berhasil diperbarui');
                $('#editTransaksiModal').modal('hide');
                $('#detailTabunganModal').modal('hide');
                location.reload();
            } else {
                alert('Gagal memperbarui transaksi');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat memperbarui transaksi');
        }
    });
});

function hapusTransaksi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
        $.ajax({
            url: `/tabungan/hapus/${id}`,
            type: 'DELETE',
            success: function(res) {
                if (res.success) {
                    alert('Transaksi berhasil dihapus');
                    location.reload();
                } else {
                    alert('Gagal menghapus transaksi');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus transaksi');
            }
        });
    }
}


</script>
@endsection
