@extends('theme.default')

@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard TPQ ASAFA</h1>

<!-- Content Row -->
<div class="row">

    <!-- Card Kelola Santri -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Santri
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSantri }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Infaq -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Infaq Bulan Ini
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

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Chart Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Grafik Infaq per Bulan</h6>
            </div>
            <!-- Chart Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="infaqChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ChartJS setup
    const ctx = document.getElementById('infaqChart').getContext('2d');
    const infaqChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $infaqLabels !!},
            datasets: [{
                label: 'Infaq Bulanan',
                data: {!! $infaqData !!},
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: 'rgba(40, 167, 69, 1)',
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

    // SweetAlert for success notification
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#2e7d5c',
        timer: 3000,
        timerProgressBar: true
      });
    @endif
</script>
@endsection
