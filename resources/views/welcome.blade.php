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
      background: linear-gradient(135deg, #ecfdf5, #d1fae5);
      overflow-x: hidden;
      color: #1e3a34;
    }

    .hero-section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 100px 10% 60px;
      background: linear-gradient(to right, #d1fae5, #bbf7d0);
      border-radius: 0 0 60px 60px;
    }

    .hero-text {
      max-width: 550px;
      animation: fadeInLeft 1s ease;
    }

    .hero-text h1 {
      font-size: 3.2rem;
      color: #065f46;
      font-weight: 700;
    }

    .hero-text p {
      font-size: 1.1rem;
      color: #1e3a34;
      margin-top: 15px;
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
      background-color: #047857;
      border: none;
      color: white;
      padding: 12px 30px;
      font-size: 1rem;
      border-radius: 30px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-custom:hover {
      background-color: #065f46;
      transform: scale(1.05);
    }

    .info-section {
      background-color: #f0fdf4;
      padding: 80px 10%;
    }

    .info-section h2 {
      color: #047857;
      font-size: 2.2rem;
      font-weight: 700;
    }

    .info-section p {
      color: #1e3a34;
      font-size: 1rem;
      margin-top: 15px;
      line-height: 1.7;
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

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-text">
      <h1>Sistem Informasi Keuangan TPQ ASAAFA</h1>
      <p>Kelola kas, tabungan, dan infaq santri secara digital, aman, dan efisien melalui satu platform terintegrasi.</p>
      <button class="btn btn-custom mt-4" onclick="toggleLogin()">Masuk Aplikasi</button>
    </div>
    <div class="hero-image">
      <img src="{{ asset('images/masjid2.png') }}" alt="Masjid">
    </div>
  </section>

  <!-- Tentang Section -->
  <section id="tentang" class="info-section text-center">
    <div class="container">
      <h2>Apa Itu Sistem Ini?</h2>
      <p>Sistem ini dirancang untuk membantu pengurus TPQ dalam mencatat dan memantau keuangan secara digital, mulai dari transaksi kas, tabungan santri, hingga pembayaran infaq bulanan. Semua terintegrasi dalam satu sistem berbasis web yang mudah diakses kapan saja.</p>
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
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>
  </div>

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

</body>
</html>
