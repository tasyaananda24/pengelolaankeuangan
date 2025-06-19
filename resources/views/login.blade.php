<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - TPQ ASAAFA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5 col-md-4">
    <div class="card shadow p-4 rounded">
      <h4 class="text-center mb-3">Login</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100" type="submit">Login</button>
      </form>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function () {
      @if (session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: @json(session('success')),
          confirmButtonColor: '#3085d6'
        });
      @endif

      @if (session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Gagal Login',
          text: @json(session('error')),
          confirmButtonColor: '#d33'
        });
      @endif
    });
  </script>
</body>
</html>
