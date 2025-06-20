@extends('theme.default')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Dashboard TPQ ASAFA</h1>

<!-- Card Row -->
<div class="row">

    <!-- Total Santri -->
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

    <!-- Total Infaq -->
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

    <!-- Total Tabungan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Tabungan Santri
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalTabungan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
<!-- Santri dengan Tabungan Tertinggi -->
<div class="col-xl-6 col-md-12 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Santri dengan Tabungan Tertinggi
                    </div>
                    @if($santriTabunganTertinggi)
                        <div class="h6 mb-1 text-gray-800">
                            {{ $santriTabunganTertinggi->nama }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($santriTabunganTertinggi->saldo, 0, ',', '.') }}
                        </div>
                    @else
                        <div class="text-muted">Belum ada data tabungan</div>
                    @endif
                </div>
                <div class="col-auto">
                    <i class="fas fa-trophy fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>


<!-- Grafik Row -->
<div class="row">

    <!-- Grafik Infaq -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Grafik Infaq Bulanan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="infaqChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Kas -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Kas Tabungan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="kasChart"></canvas>
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
    // Grafik Infaq
    const ctxInfaq = document.getElementById('infaqChart').getContext('2d');
    new Chart(ctxInfaq, {
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
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Grafik Kas
    const ctxKas = document.getElementById('kasChart').getContext('2d');
    new Chart(ctxKas, {
        type: 'bar',
        data: {
            labels: {!! $kasLabels !!},
            datasets: [{
                label: 'Saldo Kas Tabungan',
                data: {!! $kasData !!},
                backgroundColor: 'rgba(0, 123, 255, 0.3)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // SweetAlert
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
