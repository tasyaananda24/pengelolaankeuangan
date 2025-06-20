@extends('themeketua.default')

@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard TPQ ASAFA</h1>

<!-- Content Row -->
<div class="row">

    <!-- Total Debit Kas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Debit Kas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDebitKas, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kredit Kas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Kredit Kas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalKreditKas, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Santri Aktif -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Santri Aktif
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $totalSantriAktif }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Santri Tidak Aktif -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                        Total Santri Tidak Aktif
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $totalSantriTidakAktif }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user-times fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Laporan Infaq Bulan Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Laporan Infaq Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalInfaqBulanIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Chart -->
<div class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Chart Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Grafik Infaq Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</h6>
            </div>
            <!-- Chart Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="infaqChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('infaqChart').getContext('2d');

    const infaqChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Infaq Bulan Ini'],
            datasets: [{
                label: 'Total Infaq',
                data: [{{ $totalInfaqBulanIni }}],
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
