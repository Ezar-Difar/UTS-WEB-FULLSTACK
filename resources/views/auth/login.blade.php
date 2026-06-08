<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Masuk - EduSync Validator</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f4f6f9;
        }
        .login-brand {
            /* Gradasi warna biru akademik */
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        .form-floating > label {
            padding-left: 1.25rem;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                
                <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                    <div class="row g-0">
                        
                        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 login-brand text-white">
                            <div>
                                <div class="d-flex align-items-center mb-4">
                                    <i class="bi bi-shield-lock-fill fs-1 me-3 shadow-sm rounded-circle bg-white text-primary p-2"></i>
                                    <h3 class="fw-bold mb-0">EduSync Validator</h3>
                                </div>
                                <h4 class="fw-light mb-3" style="line-height: 1.4;">Sistem Validasi Kelayakan Data Program Indonesia Pintar (PIP)</h4>
                                <p class="opacity-75" style="text-align: justify;">
                                    Portal khusus verifikator. Sistem ini bertugas mencocokkan identitas siswa di Dapodik dan Dukcapil secara otomatis untuk menemukan kesalahan atau ketidaksesuaian data.
                                </p>
                            </div>
                            
                            <div class="small opacity-75">
                                <hr class="border-white opacity-25">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-building fs-3 me-3"></i>
                                    <div>
                                        <strong>Prototype Sistem</strong><br>
                                        Program Studi Teknik Informatika<br>
                                        Universitas PGRI Madiun (UNIPMA)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 p-5 bg-white d-flex flex-column justify-content-center">
                            
                            <div class="text-center mb-4 d-lg-none">
                                <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                                <h4 class="fw-bold text-primary mt-2">EduSync Validator</h4>
                            </div>

                            <div class="mb-4">
                                <h4 class="fw-bold text-dark">Portal Verifikator</h4>
                                <p class="text-muted small">Silakan masukkan kredensial akses Anda.</p>
                            </div>

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show small shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="/login" method="POST">
                                @csrf
                                
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                    <label for="email" class="text-muted"><i class="bi bi-envelope me-2"></i>Alamat Email / ID Pengguna</label>
                                </div>
                                
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    <label for="password" class="text-muted"><i class="bi bi-key me-2"></i>Kata Sandi</label>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4 small">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            Ingat sesi perangkat ini
                                        </label>
                                    </div>
                                    <a href="#" class="text-decoration-none fw-semibold">Lupa Sandi?</a>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3">
                                        Masuk ke Sistem <i class="bi bi-box-arrow-in-right ms-2"></i>
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-5 text-muted small">
                                &copy; {{ date('Y') }}.<br>
                                Dikembangkan oleh Rafid Reza Abrilian.
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
