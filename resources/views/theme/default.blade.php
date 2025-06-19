<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Keuangan TPQ Asaafa">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TPQ ASAFA - Sistem Informasi Keuangan</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
        }

        .navbar {
            background-color: #9c9e5f;
            /* Sage Green */
        }

        .navbar .navbar-nav .nav-link {
            color: #fff !important;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #e6f9e3 !important;
        }

        /* Jangan ubah warna sidebar */
        .sidebar {
            background-color: #7b7f45;
            /* Darker Sage */
        }

        .sidebar .nav-link {
            color: #ffffff !important;
        }

        .sidebar .nav-link:hover {
            background-color: #6a6e38;
        }

        /* Ubah warna topbar jadi hijau seperti sidebar */
        nav.topbar {
            background-color: #20c997 !important; /* warna hijau sidebar */
            color: white;
        }

        /* Warna teks dan icon topbar */
        .topbar .nav-link,
        .topbar .navbar-nav .nav-item .nav-link,
        .topbar .navbar-nav .nav-item .nav-link .fas {
            color: white !important;
        }

        /* Dropdown menu topbar */
        .topbar .dropdown-menu {
            background-color: #17a2b8 !important; /* hijau gelap */
            color: white;
        }

        .topbar .dropdown-menu .dropdown-item {
            color: white !important;
        }

        .topbar .dropdown-menu .dropdown-item:hover {
            background-color: #138496 !important;
            color: white !important;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header,
        .card-body {
            padding: 20px;
        }

        .footer {
            background-color: #9c9e5f;
            color: white;
            padding: 15px;
        }

        .btn-success {
            background-color: #9c9e5f;
            /* Sage Green */
            border-color: #9c9e5f;
        }

        .btn-success:hover {
            background-color: #7b7f45;
            border-color: #6a6e38;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard/bendahara') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="sidebar-brand-text mx-3">TPQ ASAFA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard/bendahara') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Keuangan
            </div>

            <!-- Nav Item - Kas -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kas.index') }}">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span>Kelola Kas</span>
                </a>
            </li>

            <!-- Nav Item - Tabungan -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tabungan.index') }}">
                    <i class="fas fa-fw fa-piggy-bank"></i>
                    <span>Kelola Tabungan</span>
                </a>
            </li>

            <!-- Nav Item - Infaq -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('infaq.index') }}">
                    <i class="fas fa-fw fa-hand-holding-usd"></i>
                    <span>Kelola Infaq</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <!-- Nav Item - Santri -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('santri.index') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Data Santri</span>
                </a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
                    <i class="fas fa-user fa-sm fa-fw text-white"></i>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil Saya
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                    </div>
                </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- Content Section -->
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; {{ date('Y') }} Sistem Informasi Keuangan TPQ Asaafa</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    @yield('scripts')

</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

