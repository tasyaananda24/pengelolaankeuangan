<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow navbar-green">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-success" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-white"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-white"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-white"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-white"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </li>

    </ul>

</nav>

<!-- Inline CSS -->
<style>
.navbar-green {
    background-color: #28a745 !important;
    color: white;
}
.navbar-green .nav-link,
.navbar-green .navbar-nav .nav-item .nav-link,
.navbar-green .topbar-divider {
    color: white !important;
}
.navbar-green .dropdown-menu {
    background-color: #218838 !important;
    color: white;
}
.navbar-green .dropdown-menu .dropdown-item {
    color: white !important;
}
.navbar-green .dropdown-menu .dropdown-item:hover {
    background-color: #28a745 !important;
    color: white !important;
}
.navbar-green .img-profile {
    border: 2px solid white;
}
</style>
