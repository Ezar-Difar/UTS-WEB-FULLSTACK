<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_validasi', function (Blueprint $table) {
            // Primary Key
            $table->id('id_log'); 
            
            // Menggunakan tipe 'string' untuk NISN karena bisa memiliki angka 0 di depan (contoh: 0987654321)
            $table->string('siswa_id', 20); 
            
            // ID Operator yang melakukan validasi
            $table->unsignedBigInteger('user_id'); 
            
            // Status hasil validasi PIP (Memperbaiki error ENUM sebelumnya)
            $table->enum('status_pip', ['Valid', 'Warning', 'Error']); 
            
            // Pesan kendala jika statusnya Error/Warning (Boleh kosong/nullable jika statusnya Valid)
            $table->text('pesan_error')->nullable(); 
            
            // Otomatis membuat kolom created_at dan updated_at
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_validasi');
    }
};