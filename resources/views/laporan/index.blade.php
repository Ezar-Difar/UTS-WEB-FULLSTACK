@extends('layouts.app')

@section('title', 'Laporan Validasi Data')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold text-secondary mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Laporan Anomali Data PIP
        </h4>
        <p class="text-muted mb-0 mt-1">Daftar siswa dengan status Error atau Warning saat sinkronisasi.</p>
    </div>
    <!-- Ubah bagian ini -->
<div class="col-md-6 text-md-end mt-3 mt-md-0">
    <a href="/laporan/cetak-pdf" class="btn btn-outline-danger me-2 shadow-sm">
        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
    </a>
    <a href="/laporan/export-excel" class="btn btn-outline-success shadow-sm">
        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
    </a>
</div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
           <table class="table table-hover align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th class="px-4 py-3">No</th>
            <th>Tanggal Cek</th>
            <th>NISN</th>
            <th>Nama (Dapodik)</th>
            <th>Status Akhir</th>
            <th>Detail Kendala</th>
            </tr>
    </thead>
    <tbody>
        @forelse($logs as $index => $log)
        <tr>
            <td class="px-4 text-muted">{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }} WIB</td>
            <td>{{ $log->siswa_id }}</td>
            <td class="fw-semibold">{{ $log->nama_siswa ?? 'Tidak Diketahui' }}</td>
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
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i> Belum ada rekaman laporan anomali data di database.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection