@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h4 class="fw-bold text-secondary mb-4">Ringkasan Validasi PIP Hari Ini</h4>

<div class="row mb-5">
    
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card bg-primary text-white border-0 shadow-sm h-100 py-1">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold small mb-1" style="letter-spacing: 0.5px;">TOTAL DATA DIPERIKSA</div>
                    <h1 class="mb-0 fw-bold display-6">{{ $total_diperiksa }}</h1>
                </div>
                <i class="bi bi-people fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card bg-success text-white border-0 shadow-sm h-100 py-1">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold small mb-1" style="letter-spacing: 0.5px;">STATUS VALID / LAYAK</div>
                    <h1 class="mb-0 fw-bold display-6">{{ $status_valid }}</h1>
                </div>
                <i class="bi bi-check-circle fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white border-0 shadow-sm h-100 py-1">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold small mb-1" style="letter-spacing: 0.5px;">ANOMALI / ERROR</div>
                    <h1 class="mb-0 fw-bold display-6">{{ $status_error }}</h1>
                </div>
                <i class="bi bi-exclamation-triangle fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-secondary mb-0">Riwayat Validasi Terakhir</h5>
    
    <div>
        <form action="/riwayat/clear" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA riwayat?');">
    @csrf
    <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm me-2">
        <i class="bi bi-trash3 me-1"></i> Bersihkan Riwayat
    </button>
</form>

        <a href="/laporan" class="btn btn-sm btn-outline-primary shadow-sm">
            Lihat Semua Laporan &rarr;
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 border-bottom-0">ID Log</th>
                        <th class="border-bottom-0">NISN</th>
                        <th class="border-bottom-0">Nama Siswa</th>
                        <th class="border-bottom-0">Waktu Validasi</th>
                        <th class="border-bottom-0">Status PIP</th>
                        <th class="border-bottom-0">Pesan Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $log)
                        <tr>
                            <td class="px-4 text-muted">#{{ $log->id_log }}</td>
                            <td>{{ $log->siswa_id }}</td>
                            <td class="fw-semibold">{{ $log->nama_siswa ?? 'Tidak Diketahui' }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</td>
                            <td>
                                @if($log->status_pip == 'Valid')
                                    <span class="badge bg-success">Valid</span>
                                @elseif($log->status_pip == 'Warning')
                                    <span class="badge bg-warning text-dark">Warning</span>
                                @else
                                    <span class="badge bg-danger">Error</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $log->pesan_error ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada aktivitas validasi data hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection