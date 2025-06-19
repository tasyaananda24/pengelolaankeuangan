<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary">
  <div class="bg-white container-sm col-6 border my-3 rounded px-5 py-3 pb-5">
    <h1>Halo {{ $user->name }}!</h1>
    <div>Selamat datang di halaman admin</div>
    <div><a href="/logout" class="btn btn-sm btn-secondary">Logout >></a></div>

    <div class="card mt-3">
      <ul class="list-group list-group-flush">
        @if($user->role === 'ketua')
          <li class="list-group-item">Anda login sebagai <strong>Ketua Yayasan</strong></li>
        @elseif($user->role === 'bendahara')
          <li class="list-group-item">Anda login sebagai <strong>Bendahara</strong></li>
        @else
          <li class="list-group-item">Peran tidak dikenal</li>
        @endif
      </ul>
    </div>
  </div>
</body>
</html>
