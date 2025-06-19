<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg p-4 rounded">
            <h4 class="text-center mb-4">Selamat datang, {{ Auth::user()->name }}!</h4>
            <p class="text-center">Ini adalah halaman dashboard Anda.</p>
            <div class="text-center">
                <a href="/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
