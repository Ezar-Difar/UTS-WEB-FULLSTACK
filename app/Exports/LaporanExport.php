<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        // Sesuaikan nama header kolom Excel
        return ['ID Log', 'NISN Siswa', 'Nama Lengkap', 'ID Operator', 'Status PIP', 'Detail Kendala', 'Waktu Dibuat', 'Waktu Diupdate'];
    }

    public function collection()
    {
        // Ambil data secara urut termasuk kolom nama_siswa
        return DB::table('log_validasi')
            ->select('id_log', 'siswa_id', 'nama_siswa', 'user_id', 'status_pip', 'pesan_error', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}