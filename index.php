<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PSA Ozamiz</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body{
      background-image: url('');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      font-family: Arial,sans-serif;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Philippine Statistics Authentication</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>  
  </nav>

  <!-- Hero Carousel -->
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active bg-light text-center p-5">
        <div class="container">
          <h1 class="display-4 fw-bold">Welcome to PSA Ozamiz</h1>
          <p class="lead">Your trusted partner in civil registration and statistical services.</p>
          <a href="#services" class="btn btn-primary btn-lg">Explore Services</a>
        </div>
      </div>
      <div class="carousel-item bg-secondary text-white text-center p-5">
        <div class="container">
          <h1 class="display-5 fw-bold">Civil Registration Made Easy</h1>
          <p class="lead">Birth, Marriage, Death Certificates — all in one place.</p>
        </div>
      </div>
      <div class="carousel-item bg-info text-white text-center p-5">
        <div class="container">
          <h1 class="display-5 fw-bold">Reliable Statistics</h1>
          <p class="lead">Supporting research, planning, and policy-making.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- About Section -->
  <section id="about" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">About Us</h2>
      <p class="text-center">The Philippine Statistics Authority (PSA) Ozamiz provides essential services in civil registration, census, and statistical data collection to support national development and local governance.</p>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Our Services</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-person-badge fs-1 text-primary"></i>
              <h5 class="mt-3">Birth Certificates</h5>
              <p>Secure certified copies of birth records quickly and efficiently.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-heart fs-1 text-danger"></i>
              <h5 class="mt-3">Marriage Certificates</h5>
              <p>Request authenticated marriage certificates for legal and personal use.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-bar-chart-line fs-1 text-success"></i>
              <h5 class="mt-3">Statistical Data</h5>
              <p>Access reliable statistics for research, planning, and policy-making.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Contact Us</h2>
      <p class="text-center">Visit our office in Ozamiz City or reach us through our official channels.</p>
      <div class="text-center">
        <a href="mailto:info@psa-ozamiz.gov.ph" class="btn btn-outline-primary btn-lg">
          <i class="bi bi-envelope"></i> Email Us
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-3">
    <p>&copy; 2026 PSA Ozamiz. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
