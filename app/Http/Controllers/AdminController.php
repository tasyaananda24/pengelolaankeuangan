<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Fungsi untuk menampilkan dashboard bendahara
   
    // Fungsi untuk menampilkan dashboard ketua
    public function ketua()
    {
        return view('dashboard.ketua'); // Pastikan ada view dashboard.ketua
    }

    // Fungsi untuk halaman admin umum
    public function index()
    {
        return view('admin'); // Ganti dengan view admin sesuai kebutuhan
    }
}
