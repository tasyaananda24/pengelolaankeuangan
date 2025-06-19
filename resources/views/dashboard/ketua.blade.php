@extends('themeketua.default')

@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard TPQ ASAFA</h1>

<!-- Content Row -->
<div class="row">

    <!-- Card Laporan Kas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Laporan Kas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 12.000.000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Laporan Infaq -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Laporan Infaq Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 3.500.000</div>
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

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Chart Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Grafik Infaq per Bulan</h6>
            </div>
            <!-- Chart Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="infaqChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('infaqChart').getContext('2d');
    const infaqChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Infaq Bulanan',
                data: [1500000, 1700000, 2200000, 2000000, 3500000, 3100000],
                backgroundColor: 'rgba(40, 167, 69, 0.1)',  // Hijau muda untuk area
                borderColor: 'rgba(40, 167, 69, 1)',        // Hijau utama untuk garis
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(40, 167, 69, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
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
