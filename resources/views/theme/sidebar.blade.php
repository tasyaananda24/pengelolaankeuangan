<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-sage sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">TPQ Asaafa</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/myHome') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Menu - Kelola Santri -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/kelola-santri') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Kelola Santri</span>
        </a>
    </li>

    <!-- Menu - Kelola Infaq -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/kelola-infaq') }}">
            <i class="fas fa-donate"></i>
            <span>Kelola Infaq</span>
        </a>
    </li>

    <!-- Menu - Kelola Tabungan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/kelola-tabungan') }}">
            <i class="fas fa-piggy-bank"></i>
            <span>Kelola Tabungan</span>
        </a>
    </li>

    <!-- Menu - Kelola Kas -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/kelola-kas') }}">
            <i class="fas fa-cash-register"></i>
            <span>Kelola Kas</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
