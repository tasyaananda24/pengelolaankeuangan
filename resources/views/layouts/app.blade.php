<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="bg-light">
    <!-- Navbar for navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/kelola-santri">Kelola Data Santri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/kelola-kas">Kelola Kas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/kelola-tabungan">Kelola Tabungan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/kelola-infaq">Kelola Infaq</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
