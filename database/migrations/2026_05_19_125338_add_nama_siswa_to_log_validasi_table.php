<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('log_validasi', function (Blueprint $table) {
        // Menambahkan kolom nama_siswa setelah kolom siswa_id
        $table->string('nama_siswa', 150)->after('siswa_id')->nullable();
    });
}

public function down()
{
    Schema::table('log_validasi', function (Blueprint $table) {
        $table->dropColumn('nama_siswa');
    });
}
};
