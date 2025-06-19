@extends('theme.default')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data Santri</h1>
        <button class="btn btn-success" data-toggle="modal" data-target="#tambahSantriModal">
            <i class="fas fa-plus"></i> Tambah Santri
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 font-weight-bold text-success">Data Santri</h6>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <!-- Filter status -->
                <label for="filterStatus" class="mb-0 mr-2">Status:</label>
                <select id="filterStatus" class="form-control form-control-sm mr-3" onchange="filterSantri()">
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                </select>

                <!-- Form pencarian -->
                <form method="GET" action="{{ url()->current() }}" class="form-inline">
                    <input type="hidden" name="status" value="{{ request('status', 'Semua') }}">
                    <input type="text" name="search" class="form-control form-control-sm mr-2"
                        placeholder="Cari nama santri..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Nama Orang Tua</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($santris as $index => $santri)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $santri->nama }}</td>
                                <td>{{ $santri->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                <td>{{ $santri->alamat }}</td>
                                <td>{{ $santri->nama_ortu }}</td>
                                <td>{{ $santri->no_hp }}</td>
                                <td>
                                    <span class="badge badge-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }}">
                                        {{ $santri->status }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editSantriModal"
                                        onclick="isiFormEdit({{ $santri }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                
                                </td>
                            </tr>
                        @endforeach

                        @if($santris->isEmpty())
                            <tr><td colspan="8" class="text-center">Belum ada data santri.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
@include('santri.modal-tambah')

<!-- Modal Edit -->
@include('santri.modal-edit')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            searching: false,
            lengthChange: false,
            paging: false, // opsional jika pagination tidak diperlukan
            info: false
        });
    });

    function isiFormEdit(santri) {
        $('#edit_id').val(santri.id);
        $('#edit_nama').val(santri.nama);
        $('#edit_tempat_lahir').val(santri.tempat_lahir);
        $('#edit_tanggal_lahir').val(santri.tanggal_lahir);
        $('#edit_alamat').val(santri.alamat);
        $('#edit_nama_ortu').val(santri.nama_ortu);
        $('#edit_no_hp').val(santri.no_hp);
        $('#edit_status').val(santri.status);
        $('#formEditSantri').attr('action', '/santri/' + santri.id);
        $('#editSantriModal').modal('show');
    }

    function filterSantri() {
        const status = $('#filterStatus').val();
        const url = new URL(window.location.href);
        url.searchParams.set('status', status);
        window.location.href = url.toString();
    }

    
</script>
@endsection
