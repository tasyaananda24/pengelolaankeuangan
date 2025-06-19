<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('login'); // Sesuaikan dengan nama view login kamu
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Simpan session sukses login agar bisa tampil alert di view
            $successMessage = 'Login berhasil! Selamat datang, ' . $user->nama;

            if ($user->role == 'bendahara') {
                return redirect()->route('bendahara')->with('success', $successMessage);
            } elseif ($user->role == 'ketua') {
                return redirect()->route('ketua')->with('success', $successMessage);
            }

            // Default redirect jika role lain atau belum ditangani
            return redirect('/')->with('success', $successMessage);
        }

        // Jika gagal login, kembali ke login dengan error
        return redirect()->back()->with('error', 'Email atau password salah!');
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
