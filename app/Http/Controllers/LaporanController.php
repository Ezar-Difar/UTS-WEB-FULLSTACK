<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\Database\Schema;
use Illuminate\Support\Facades\DB;

class LaporanController 
{
    public function cetakPDF()
    {
        // Menarik data riwayat validasi asli langsung dari database MySQL
        $data = DB::table('log_validasi')->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('laporan.pdf', ['data' => $data]);
        return $pdf->download('Laporan_Anomali_PIP_EduSync.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'Laporan_Anomali_PIP_EduSync.xlsx');
    }
}