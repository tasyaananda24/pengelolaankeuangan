<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <nav class="d-flex justify-content-between mb-4">
        <div><strong>{{ auth()->user()->role }}</strong></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </nav>

    @yield('content')
</body>
</html>
