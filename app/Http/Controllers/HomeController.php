<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan halaman utama sebelum login
    public function index()
    {
        return view('welcome');  // Halaman utama yang dapat diakses sebelum login
    }

    // Menampilkan halaman utama setelah login
    public function home()
    {
        return view('home');  // Halaman yang akan ditampilkan setelah login
    }
}
