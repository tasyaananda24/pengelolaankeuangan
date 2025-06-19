@extends('theme.default')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
        </div>

        <!-- Laporan Kas Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Laporan Kas</h6>
            </div>
            <div class="card-body">
                <form action="{{ url('/laporan/kas') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_awal" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_akhir" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-info btn-block" onclick="cetakLaporanKas()">
                                    <i class="fas fa-print"></i> Cetak Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-01-15</td>
                                <td>Sumbangan Donatur</td>
                                <td>Rp 0</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 5.000.000</td>
                            </tr>
                            <tr>
                                <td>2024-01-14</td>
                                <td>Pembayaran Listrik</td>
                                <td>Rp 500.000</td>
                                <td>Rp 0</td>
                                <td>Rp 4.500.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="2">Total</td>
                                <td>Rp 500.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 4.500.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Laporan Infaq Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Laporan Infaq</h6>
            </div>
            <div class="card-body">
                <form action="{{ url('/laporan/infaq') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_awal" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_akhir" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-info btn-block" onclick="cetakLaporanInfaq()">
                                    <i class="fas fa-print"></i> Cetak Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Donatur</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-01-15</td>
                                <td>Hamba Allah</td>
                                <td>Rp 1.000.000</td>
                                <td>Infaq Pembangunan</td>
                            </tr>
                            <tr>
                                <td>2024-01-14</td>
                                <td>Hamba Allah</td>
                                <td>Rp 500.000</td>
                                <td>Infaq Rutin</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="2">Total</td>
                                <td colspan="2">Rp 1.500.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function cetakLaporanKas() {
            var tanggalAwal = $('input[name="tanggal_awal"]').first().val();
            var tanggalAkhir = $('input[name="tanggal_akhir"]').first().val();

            if (tanggalAwal && tanggalAkhir) {
                window.open('/laporan/kas/cetak?tanggal_awal=' + tanggalAwal + '&tanggal_akhir=' + tanggalAkhir, '_blank');
            } else {
                alert('Silakan pilih rentang tanggal terlebih dahulu');
            }
        }

        function cetakLaporanInfaq() {
            var tanggalAwal = $('input[name="tanggal_awal"]').last().val();
            var tanggalAkhir = $('input[name="tanggal_akhir"]').last().val();

            if (tanggalAwal && tanggalAkhir) {
                window.open('/laporan/infaq/cetak?tanggal_awal=' + tanggalAwal + '&tanggal_akhir=' + tanggalAkhir,
                    '_blank');
            } else {
                alert('Silakan pilih rentang tanggal terlebih dahulu');
            }
        }
    </script>
@endsection
