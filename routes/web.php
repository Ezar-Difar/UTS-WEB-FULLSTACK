<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

// --- RUTE AUTENTIKASI ---
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    // 1. Dapatkan tanggal hari ini
    $hariIni = \Carbon\Carbon::today();

    // 2. Hitung statistik khusus untuk hari ini
    $totalDiperiksa = DB::table('log_validasi')
                        ->whereDate('created_at', $hariIni)
                        ->count();
                        
    $statusValid = DB::table('log_validasi')
                        ->where('status_pip', 'Valid')
                        ->whereDate('created_at', $hariIni)
                        ->count();
                        
    // Menggabungkan Error dan Warning ke dalam satu kotak "Anomali / Error"
    $statusError = DB::table('log_validasi')
                        ->whereIn('status_pip', ['Error', 'Warning'])
                        ->whereDate('created_at', $hariIni)
                        ->count();

    // 3. Ambil 5 riwayat terakhir (seperti sebelumnya)
    $riwayatValidasi = DB::table('log_validasi')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

    // 4. Kirim semua variabel ke tampilan (view)
    return view('dashboard.index', [
        'riwayat' => $riwayatValidasi,
        'total_diperiksa' => $totalDiperiksa,
        'status_valid' => $statusValid,
        'status_error' => $statusError
    ]);
});
Route::post('/validasi-siswa', function (Illuminate\Http\Request $request) {
    // 1. Validasi Input Dasar
    $request->validate([
        'nik' => 'required|digits:16',
        'nisn' => 'required|digits:10',
        'nama_dapodik' => 'required|string',
    ]);

    $nikInput = $request->nik;
    $nisnInput = $request->nisn;
    $namaInput = strtoupper(trim($request->nama_dapodik));

    // ====================================================================
    // 2. MOCK API PUSAT (Rekayasa Database Server Dukcapil & Pusdatin)
    // ====================================================================
    $databasePusat = [
        '3519011111111111' => ['nama' => 'RAFID REZA ABRILIAN', 'status_hidup' => true],
        '3519011111111112' => ['nama' => 'DENOVAN SEPTIAN JOVANA', 'status_hidup' => true],
        '3519022222222222' => ['nama' => 'REGAN ALTHAF PUTRA ALPIKO', 'status_hidup' => true],
        '3519033333333333' => ['nama' => 'BUDI SANTOSO', 'status_hidup' => false], // Rekayasa: Status Meninggal
    ];

    $status = '';
    $pesan = '';
    $flashKey = '';
    $flashMessage = '';

    // ====================================================================
    // 3. MESIN DETEKSI ANOMALI
    // ====================================================================
    
    // ANOMALI 1: Pengecekan Duplikasi (Apakah NISN ini sudah divalidasi sebelumnya?)
    $cekDuplikasi = DB::table('log_validasi')->where('siswa_id', $nisnInput)->exists();
    
    if ($cekDuplikasi) {
        $status = 'Error';
        $pesan = "Anomali Duplikasi: NISN $nisnInput sudah pernah divalidasi sebelumnya.";
        $flashKey = 'error';
        $flashMessage = "Gagal! Data dengan NISN tersebut sudah tercatat di sistem (Indikasi Data Ganda).";
    } 
    // Mengecek apakah NIK ada di "Database Pusat"
    elseif (!array_key_exists($nikInput, $databasePusat)) {
        // ANOMALI 2: NIK Fiktif / Tidak Ditemukan
        $status = 'Error';
        $pesan = "Anomali Data: NIK $nikInput tidak terdaftar di server Dukcapil.";
        $flashKey = 'error';
        $flashMessage = "Gagal! NIK tidak ditemukan di database kependudukan pusat.";
    } 
    else {
        // Jika NIK ditemukan, ambil data aslinya
        $dataAsli = $databasePusat[$nikInput];
        
        // ANOMALI 3: Anomali Logika (Status Kependudukan)
        if ($dataAsli['status_hidup'] == false) {
            $status = 'Error';
            $pesan = "Anomali Logika: NIK terdaftar dengan status Meninggal Dunia.";
            $flashKey = 'error';
            $flashMessage = "Sinkronisasi Ditolak! Status kependudukan siswa tidak valid (Meninggal Dunia).";
        } 
        else {
            // ANOMALI 4: Anomali Ejaan (Fuzzy Matching Kemiripan Nama)
            similar_text($namaInput, $dataAsli['nama'], $persentase);
            $persentase = round($persentase, 1);

            if ($persentase == 100) {
                $status = 'Valid';
                $pesan = null;
                $flashKey = 'success';
                $flashMessage = "Data Valid! Identitas siswa sinkron 100% antara Dapodik dan Dukcapil.";
            } elseif ($persentase >= 70) {
                $status = 'Warning';
                $pesan = "Anomali Ejaan ($persentase% Mirip). Dapodik: $namaInput | Pusat: " . $dataAsli['nama'];
                $flashKey = 'warning';
                $flashMessage = "Siswa valid, namun terdeteksi perbedaan ejaan nama (Typo/Singkatan).";
            } else {
                $status = 'Error';
                $pesan = "Ketidakcocokan Identitas (Kemiripan $persentase%). Dapodik: $namaInput | Pusat: " . $dataAsli['nama'];
                $flashKey = 'error';
                $flashMessage = "Gagal! Nama di Dapodik sangat berbeda dengan pemilik NIK di Dukcapil.";
            }
        }
    }

    // ====================================================================
    // 4. SIMPAN KE DATABASE
    // ====================================================================
    DB::table('log_validasi')->insert([
        'siswa_id' => $nisnInput,
        'nama_siswa' => $namaInput,
        'user_id' => auth()->id() ?? 1,
        'status_pip' => $status,
        'pesan_error' => $pesan,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ]);

    return redirect('/validasi')->with($flashKey, $flashMessage);
});

// --- RUTE HALAMAN FORM VALIDASI ---
Route::get('/validasi', function () { return view('validasi.index'); });

// --- RUTE HALAMAN LAPORAN (Ambil Semua Data dari DB) ---
Route::get('/laporan', function () {
    $allLogs = DB::table('log_validasi')->orderBy('created_at', 'desc')->get();
    return view('laporan.index', ['logs' => $allLogs]);
});

Route::post('/riwayat/clear', function () {
    DB::table('log_validasi')->truncate();
    return back()->with('success', 'Seluruh riwayat validasi berhasil dihapus!');
});

// --- RUTE CETAK & EXPORT ---
Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPDF']);
Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel']);