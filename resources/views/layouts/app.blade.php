<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSync Validator - @yield('title')</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .navbar-brand { font-weight: bold; color: #2c3e50 !important; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shield-check text-primary"></i> EduSync Validator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active fw-bold' : '' }}" href="/dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('validasi') ? 'active fw-bold' : '' }}" href="/validasi">Validasi Data</a>
        </li>
        <li class="nav-item">
            <!-- Tautan Laporan diperbarui -->
            <a class="nav-link {{ request()->is('laporan') ? 'active fw-bold' : '' }}" href="/laporan">Laporan</a>
        </li>
    </ul>
    
    <div class="d-flex align-items-center">
        <span class="navbar-text me-3">
            <i class="bi bi-person-circle"></i> Operator Sekolah
        </span>
        
        <!-- Form Logout diperbarui -->
        <form action="/logout" method="POST" class="m-0">
            @csrf <!-- Wajib ada agar Laravel mengizinkan proses POST -->
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="mt-auto py-4 bg-light border-top">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            
            <div class="col-md-6 mb-3 mb-md-0">
                <h6 class="fw-bold text-secondary mb-1">
                    <i class="bi bi-shield-check me-1"></i> EduSync Validator
                </h6>
                <div class="small text-muted" style="line-height: 1.6;">
                    Prototipe Sistem Validasi Kelayakan Data PIP<br>
                    &copy; {{ date('Y') }}.
                </div>
            </div>

            <div class="col-md-6 text-md-end border-start-md">
                <div class="small text-muted" style="line-height: 1.6;">
                    <strong>Peneliti:</strong> Rafid Denovan<br>
                    <strong>Dosen Pembimbing:</strong> SRI ANARDANI, S.Kom, M.T<br>
                    Program Studi Teknik Informatika<br>
                    Universitas PGRI Madiun (UNIPMA)
                </div>
            </div>

        </div>
    </div>
</footer>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>