<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page | TPQ ASAFA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fbf9;
      overflow-x: hidden;
    }

    .navbar {
      background-color: #2e7d5c;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 600;
    }

    .nav-link:hover {
      text-decoration: underline;
    }

    .hero-section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 100px 10% 60px;
      background: linear-gradient(to right, #e3f2ef, #c7e1d8);
    }

    .hero-text {
      max-width: 550px;
      animation: fadeInLeft 1s ease;
    }

    .hero-text h1 {
      font-size: 3rem;
      color: #2e7d5c;
      font-weight: 700;
    }

    .hero-text p {
      font-size: 1.2rem;
      color: #486c5a;
      margin-top: 10px;
    }

    .hero-image img {
      max-width: 100%;
      height: auto;
      animation: fadeInRight 1s ease;
    }

    @keyframes fadeInLeft {
      from {opacity: 0; transform: translateX(-30px);}
      to {opacity: 1; transform: translateX(0);}
    }

    @keyframes fadeInRight {
      from {opacity: 0; transform: translateX(30px);}
      to {opacity: 1; transform: translateX(0);}
    }

    .btn-custom {
      background-color: #2e7d5c;
      border: none;
      color: white;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #25644b;
      transform: scale(1.05);
    }

    .info-section, .contact-info {
      background-color: #f1f8f4;
    }

    .info-section h2, .contact-box h5 {
      color: #2e7d5c;
    }

    .info-section p, .contact-box p {
      color: #4a6755;
      font-size: 1rem;
    }

    footer {
      background-color: #2e7d5c;
      color: #fff;
      text-align: center;
      padding: 20px 0;
    }

    .contact-box {
      padding: 25px;
      border-radius: 15px;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .overlay, .login-box {
      display: none;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }

    .login-box {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 90%;
      max-width: 400px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 1.5rem;
      background: none;
      border: none;
      color: #888;
      cursor: pointer;
    }

    .close-btn:hover {
      color: #000;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg py-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">TPQ ASAAFA (YKIA)</a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#" onclick="toggleLogin()">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-text">
      <h1>Sistem Informasi Keuangan<br>TPQ ASAAFA</h1>
      <p>Kelola keuangan, tabungan, dan infaq santri secara digital, akurat, dan transparan.</p>
      <button class="btn btn-custom mt-4 px-4 py-2" onclick="toggleLogin()">Masuk</button>
    </div>
    <div class="hero-image">
      <img src="{{ asset('images/masjid2.png') }}" alt="Masjid">
    </div>
  </section>

  <!-- Overlay & Login Modal -->
  <div id="overlay" class="overlay" onclick="toggleLogin()"></div>

  <div id="loginBox" class="login-box">
    <button class="close-btn" onclick="toggleLogin()">&times;</button>
    <h4 class="text-center mb-4">Login Akun</h4>

    @if ($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/login">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>
  </div>

  <!-- Tentang Section -->
  <section id="tentang" class="info-section py-5 text-center">
    <div class="container">
      <h2 class="mb-4">Tentang Aplikasi</h2>
      <p>Aplikasi ini dirancang untuk membantu bendahara TPQ dalam mencatat dan mengelola data keuangan secara digital. Dengan sistem yang terintegrasi, pelaporan keuangan menjadi lebih mudah dan akurat.</p>
    </div>
  </section>

  <!-- Kontak Section -->
  <section id="kontak" class="contact-info py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-6 mb-4">
          <div class="contact-box">
            <h5>📍 Lokasi TPQ</h5>
            <p>Jl. Karya Bakti RT 20 RW 014, Kelurahan Sukamelang, Kecamatan Subang, Kabupaten Subang</p>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="contact-box">
            <h5>📞 Kontak</h5>
            <p>Email: info@tpqasafa.sch.id<br>Telp: 0812-3456-7890</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 TPQ ASAFA. Seluruh Hak Dilindungi.</p>
  </footer>

  <!-- Script Login -->
  <script>
    function toggleLogin() {
      const loginBox = document.getElementById('loginBox');
      const overlay = document.getElementById('overlay');

      const isVisible = loginBox.style.display === 'block';
      loginBox.style.display = isVisible ? 'none' : 'block';
      overlay.style.display = isVisible ? 'none' : 'block';
    }
  </script>
  <!-- ... kode HTML kamu tetap sama ... -->

<!-- Script Login -->
<script>
  function toggleLogin() {
    const loginBox = document.getElementById('loginBox');
    const overlay = document.getElementById('overlay');

    const isVisible = loginBox.style.display === 'block';
    loginBox.style.display = isVisible ? 'none' : 'block';
    overlay.style.display = isVisible ? 'none' : 'block';
  }
</script>

<!-- Tambahan untuk alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
   
    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal Login',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33'
      });
      // Otomatis buka modal login jika gagal
      toggleLogin();
    @endif
  });
</script>

</body>
</html>
