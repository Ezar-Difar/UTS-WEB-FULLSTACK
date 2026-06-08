@extends('layouts.app')

@section('title', 'Validasi Data Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h4 class="fw-bold text-secondary mb-1">Modul Sinkronisasi PIP</h4>
        <div class="text-muted small">Pencocokan Identitas Siswa: Dapodik Kemdikbud &mdash; SIAK Dukcapil</div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> <strong>DATA VALID!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>PERINGATAN!</strong> {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
    <i class="bi bi-x-circle-fill me-2"></i> <strong>ANOMALI TERDETEKSI!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Validasi Form Gagal!</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm h-100 bg-light">
            <div class="card-body p-4">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-info-square-fill me-2"></i> SOP Validasi Data
                </h6>
                <p class="small text-muted mb-4" style="text-align: justify;">
                    Pastikan data yang diinputkan sesuai dengan dokumen resmi siswa. Kesalahan input berulang dapat menyebabkan pemblokiran sementara pada NISN terkait.
                </p>
                
                <ul class="list-unstyled small mb-4">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-1-circle text-primary fs-5 me-2" style="line-height: 1;"></i>
                        <div>
                            <strong>NIK (16 Digit)</strong><br>
                            <span class="text-muted">Nomor Induk Kependudukan harus sesuai dengan Kartu Keluarga (KK) terbaru.</span>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-2-circle text-primary fs-5 me-2" style="line-height: 1;"></i>
                        <div>
                            <strong>NISN (10 Digit)</strong><br>
                            <span class="text-muted">Pastikan siswa memiliki NISN aktif yang diterbitkan oleh Pusdatin Kemdikbud.</span>
                        </div>
                    </li>
                    <li class="mb-0 d-flex align-items-start">
                        <i class="bi bi-3-circle text-primary fs-5 me-2" style="line-height: 1;"></i>
                        <div>
                            <strong>Nama Lengkap</strong><br>
                            <span class="text-muted">Ditulis tanpa gelar, tanpa singkatan (kecuali memang tertulis singkatan di Akta Kelahiran).</span>
                        </div>
                    </li>
                </ul>

                <hr>
                <div class="d-flex align-items-center mt-3 text-muted" style="font-size: 0.75rem;">
                    <i class="bi bi-shield-lock-fill fs-4 me-2 text-success"></i>
                    <span>Pertukaran data dilindungi oleh enkripsi standar (End-to-End). Privacy Policy &amp; UU ITE terakomodasi.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-keyboard me-2"></i> Form Input Data Siswa
                </h6>
            </div>
            <div class="card-body p-4 p-md-5">
                
                <form action="/validasi-siswa" method="POST">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="nik" class="form-label fw-semibold text-secondary">Nomor Induk Kependudukan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-vcard"></i></span>
                                <input type="text" class="form-control form-control-lg fs-6" id="nik" name="nik" placeholder="16 Digit NIK" maxlength="16" minlength="16" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nisn" class="form-label fw-semibold text-secondary">Nomor Induk Siswa Nasional</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                                <input type="text" class="form-control form-control-lg fs-6" id="nisn" name="nisn" placeholder="10 Digit NISN" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="nama_dapodik" class="form-label fw-semibold text-secondary">Nama Lengkap (Sesuai Data Dapodik)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control form-control-lg fs-6" id="nama_dapodik" name="nama_dapodik" placeholder="Ketik nama lengkap siswa..." required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4">
                        <button type="reset" class="btn btn-light me-3 px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-hdd-network me-2"></i> Sinkronisasi ke Pusat
                        </button>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>
</div>
@endsection