<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKas;
use App\Models\Infaq;
use App\Models\Santri;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard untuk bendahara
     */
    public function index()
    {
        $data = $this->getDashboardData();

        return view('dashboard.bendahara', $data);
    }

    /**
     * Menampilkan dashboard untuk ketua yayasan
     */
    public function ketua()
    {
        $data = $this->getDashboardData();

        return view('dashboard.ketua', $data);
    }

    /**
     * Menampilkan halaman admin umum
     */
    public function admin()
    {
        return view('admin');
    }

    /**
     * Fungsi privat untuk mengambil data kas dan infaq bulan ini
     */
  private function getDashboardData()
{
    $now = Carbon::now();

    $totalKas = TransaksiKas::selectRaw("
        SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) -
        SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END)
    AS saldo")->value('saldo') ?? 0;

    $totalDebitKas = TransaksiKas::where('jenis', 'debit')->sum('jumlah') ?? 0;
    $totalKreditKas = TransaksiKas::where('jenis', 'kredit')->sum('jumlah') ?? 0;

    $totalInfaqBulanIni = Infaq::whereYear('tanggal', $now->year)
        ->whereMonth('tanggal', $now->month)
        ->sum('jumlah');

    $totalSantriAktif = Santri::where('status', 'aktif')->count();
    $totalSantriTidakAktif = Santri::where('status', 'tidak aktif')->count();

    return [
        'totalKas' => $totalKas,
        'totalDebitKas' => $totalDebitKas,
        'totalKreditKas' => $totalKreditKas,
        'totalInfaqBulanIni' => $totalInfaqBulanIni,
        'totalSantriAktif' => $totalSantriAktif,
        'totalSantriTidakAktif' => $totalSantriTidakAktif,
    ];
}

}
