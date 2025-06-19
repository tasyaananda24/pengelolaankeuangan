@extends('themeketua.default')

@section('title', 'Laporan Data Santri - TPQ ASAAFA')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="font-size: 32px;">Laporan Data Santri</h4>
        <h5 class="fw-semibold" style="font-size: 24px;">TPQ ASAAFA</h5>
        <p style="font-size: 18px;">Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <!-- Search Input + Button -->
    <div class="input-group mb-3 no-print" style="max-width: 450px; margin-left: auto; margin-right: auto;">
        <input
            type="text"
            id="searchInput"
            placeholder="Cari data santri atau status..."
            class="form-control"
            style="font-size: 18px; padding: 14px 20px; border-radius: 30px 0 0 30px; box-shadow: 0 3px 10px rgba(0,0,0,0.15); border-right: none;"
        >
        <button
            class="btn btn-primary"
            id="searchBtn"
            style="font-size: 18px; padding: 14px 30px; border-radius: 0 30px 30px 0; box-shadow: 0 3px 10px rgba(0,123,255,0.4); border-left: none;"
        >
            Cari
        </button>
    </div>

    <table
        class="table table-bordered"
        id="santriTable"
        style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-size: 18px;"
    >
        <thead class="thead-light" style="background-color: #007bff; color: white;">
            <tr>
                <th style="padding: 20px 25px;">No</th>
                <th style="padding: 20px 25px;">Nama</th>
                <th style="padding: 20px 25px;">Tempat, Tanggal Lahir</th>
                <th style="padding: 20px 25px;">Alamat</th>
                <th style="padding: 20px 25px;">Nama Orang Tua</th>
                <th style="padding: 20px 25px;">No. HP</th>
                <th style="padding: 20px 25px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($santris as $index => $santri)
                <tr style="{{ $index % 2 == 0 ? 'background-color:#f9f9f9' : 'background-color:#ffffff' }}; cursor: default;">
                    <td style="padding: 20px 25px;">{{ $index + 1 }}</td>
                    <td style="padding: 20px 25px;">{{ $santri->nama }}</td>
                    <td style="padding: 20px 25px;">{{ $santri->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    <td style="padding: 20px 25px;">{{ $santri->alamat }}</td>
                    <td style="padding: 20px 25px;">{{ $santri->nama_ortu }}</td>
                    <td style="padding: 20px 25px;">{{ $santri->no_hp }}</td>
                    <td style="padding: 20px 25px;">
                        @if(strtolower($santri->status) === 'aktif')
                            <span class="badge badge-status-aktif">{{ $santri->status }}</span>
                        @else
                            <span class="badge badge-status-tidakaktif">{{ $santri->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="font-size: 18px; padding: 20px;">Belum ada data santri.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="text-center no-print mt-4">
        <button
            class="btn btn-primary btn-lg"
            onclick="window.print()"
            style="font-size: 20px; padding: 14px 40px; border-radius: 30px; box-shadow: 0 4px 15px rgba(0,123,255,0.4); transition: background-color 0.3s ease, box-shadow 0.3s ease;"
        >
            Cetak Laporan
        </button>
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

    tbody tr:hover {
        background-color: #d0e5ff !important;
    }

    .badge-status-aktif {
        background-color: #28a745;
        color: white;
        font-weight: 700;
        font-size: 16px;
        padding: 8px 20px;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.6);
        border-radius: 12px;
    }

    .badge-status-tidakaktif {
        background-color: #6c757d;
        color: white;
        font-weight: 700;
        font-size: 16px;
        padding: 8px 20px;
        box-shadow: 0 0 8px rgba(108, 117, 125, 0.6);
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        #searchInput {
            font-size: 16px !important;
            padding: 12px 16px !important;
        }

        table th, table td {
            font-size: 16px !important;
            padding: 14px 18px !important;
        }

        .btn-primary.btn-lg {
            font-size: 18px !important;
            padding: 12px 30px !important;
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
        let visibleRows = 0;

        trs.forEach(row => {
            if (row.children.length === 1 && row.children[0].getAttribute('colspan') == '7') {
                if (filter === '') {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
                return;
            }

            let rowText = '';
            row.querySelectorAll('td').forEach(td => {
                rowText += td.textContent.toLowerCase() + ' ';
            });

            if (rowText.indexOf(filter) > -1) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById("searchInput");
        const button = document.getElementById("searchBtn");

        input.addEventListener('keyup', filterTable);
        button.addEventListener('click', filterTable);
    });
</script>
@endpush
