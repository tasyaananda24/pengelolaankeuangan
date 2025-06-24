@extends('themeketua.default')

@section('title', 'Laporan Data Santri - TPQ ASAAFA')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="font-size: 32px; border-bottom: 3px solid #007bff; display: inline-block; padding-bottom: 6px;">
            Laporan Data Santri
        </h4>
        <h5 class="fw-semibold mt-2" style="font-size: 24px;">TPQ ASAAFA</h5>
        <p style="font-size: 18px;">Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <!-- Tombol Unduh PDF -->
    <div class="text-end mb-4 no-print">
        <a href="{{ route('santri.download.pdf') }}" class="btn btn-success shadow-sm" style="border-radius: 30px; font-size: 16px; padding: 12px 25px;">
            <i class="fas fa-file-pdf me-2"></i> Unduh PDF
        </a>
    </div>

    <!-- Search -->
    <div class="no-print d-flex justify-content-center mb-4">
        <div class="input-group" style="max-width: 500px; border-radius: 30px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama, status, alamat..."
                class="form-control"
                style="border: none; padding: 14px 20px; font-size: 16px;"
            >
            <button
                class="btn btn-primary"
                id="searchBtn"
                style="border: none; font-size: 16px; padding: 14px 25px;"
            >
                Cari
            </button>
        </div>
    </div>

    <!-- Tabel Santri -->
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="santriTable" style="font-size: 17px;">
            <thead class="thead-light" style="background-color: #007bff; color: white;">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Nama Orang Tua</th>
                    <th>No. HP</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $index => $santri)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $santri->nama }}</td>
                        <td>{{ $santri->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                        <td>{{ $santri->alamat }}</td>
                        <td>{{ $santri->nama_ortu }}</td>
                        <td>{{ $santri->no_hp }}</td>
                        <td>
                            @if(strtolower($santri->status) === 'aktif')
                                <span class="badge badge-success px-3 py-2 rounded-pill shadow">Aktif</span>
                            @else
                                <span class="badge badge-secondary px-3 py-2 rounded-pill shadow">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data santri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
        font-weight: 600;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: #fff;
        font-weight: 600;
    }

    tbody tr:hover {
        background-color: #f1f9ff !important;
    }

    @media (max-width: 576px) {
        #searchInput {
            font-size: 14px !important;
        }

        #searchBtn {
            font-size: 14px !important;
            padding: 12px 20px !important;
        }

        table th, table td {
            font-size: 15px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("santriTable");
        const trs = table.querySelectorAll("tbody tr");

        trs.forEach(row => {
            if (row.children.length === 1 && row.children[0].getAttribute('colspan') == '7') {
                row.style.display = (filter === '') ? '' : 'none';
                return;
            }

            let rowText = '';
            row.querySelectorAll('td').forEach(td => {
                rowText += td.textContent.toLowerCase() + ' ';
            });

            row.style.display = (rowText.includes(filter)) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById("searchInput").addEventListener('keyup', filterTable);
        document.getElementById("searchBtn").addEventListener('click', filterTable);
    });
</script>
@endpush
