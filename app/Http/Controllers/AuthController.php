<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController 
{
    /**
     * Memproses logika autentikasi login (Operator Sekolah)
     */
    public function login(Request $request)
    {
        // 1. Validasi input form secara lokal
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek kecocokan kredensial ke database MySQL (Menggunakan Fasad Auth)
        // Laravel otomatis akan mencocokkan email dan melakukan de-hash pada password
        if (Auth::attempt($credentials)) {
            
            // 3. Jika benar, amankan sesi dengan meregenerasi ID Session (Mencegah Session Fixation)
            $request->session()->regenerate();
 
            // 4. Dialihkan ke halaman dashboard yang dituju
             return redirect('/dashboard');
        }
 
        // 5. Jika salah, kembalikan ke halaman login dengan membawa pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email'); // Mempertahankan input email lama di form agar user tidak ketik ulang
    }

    /**
     * Memproses logika keluar sistem (Logout)
     */
    public function logout(Request $request)
    {
        // 1. Hapus status autentikasi pengguna
        Auth::logout();
 
        // 2. Hancurkan seluruh data sesi pengguna saat ini di server
        $request->session()->invalidate();
 
        // 3. Regenerasi token CSRF baru demi keamanan agar token lama tidak bisa disalahgunakan
        $request->session()->regenerateToken();
 
        // 4. Alihkan kembali operator ke halaman login utama (rute akar)
        return redirect('/');
    }
}