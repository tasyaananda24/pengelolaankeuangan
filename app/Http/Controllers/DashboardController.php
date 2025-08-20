<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Infaq;
use App\Models\Tabungan;
use App\Models\TransaksiKas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    public function ketua()
    {
        $now = Carbon::now();

        // === Total Kas ===
        $totalDebitKas = TransaksiKas::where('jenis', 'debit')->sum('jumlah');
        $totalKreditKas = TransaksiKas::where('jenis', 'kredit')->sum('jumlah');

        // === Total Infaq Bulan Ini ===
        $totalInfaqBulanIni = Infaq::whereYear('tanggal', $now->year)
            ->whereMonth('tanggal', $now->month)
            ->sum('jumlah');

        // === Total Santri Aktif & Tidak Aktif ===
        $totalSantriAktif = Santri::where('status', 'aktif')->count();
        $totalSantriTidakAktif = Santri::where('status', 'tidak aktif')->count();

        // === Grafik Infaq Tahunan ===
        $infaqBulanan = Infaq::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->whereYear('tanggal', $now->year)
            ->groupByRaw('MONTH(tanggal)')
            ->orderByRaw('MONTH(tanggal)')
            ->get();

        $infaqLabels = [];
        $infaqData = [];
        for ($i = 1; $i <= 12; $i++) {
            $infaqLabels[] = Carbon::create()->month($i)->locale('id')->isoFormat('MMMM');
            $infaqData[] = $infaqBulanan->firstWhere('bulan', $i)->total ?? 0;
        }

       // === TOTAL TABUNGAN ===
    $totalTabungan = Tabungan::selectRaw("
        SUM(CASE WHEN jenis = 'setoran' THEN jumlah ELSE 0 END) - 
        SUM(CASE WHEN jenis = 'penarikan' THEN jumlah ELSE 0 END)
    AS saldo")->value('saldo');


        // === Santri dengan Saldo Tabungan Tertinggi ===
        $santriTertinggi = Tabungan::select('santri_id', DB::raw("
    SUM(CASE WHEN jenis = 'setoran' THEN jumlah ELSE 0 END) -
    SUM(CASE WHEN jenis = 'penarikan' THEN jumlah ELSE 0 END) AS saldo
"))
->groupBy('santri_id')
->orderByDesc('saldo')
->with('santri') // pastikan relasi `santri()` ada di model Tabungan
->first();



        return view('dashboard.ketua', [
            'totalDebitKas' => $totalDebitKas,
            'totalKreditKas' => $totalKreditKas,
            'totalSantriAktif' => $totalSantriAktif,
            'totalSantriTidakAktif' => $totalSantriTidakAktif,
            'totalInfaqBulanIni' => $totalInfaqBulanIni,
              'totalTabungan' => $totalTabungan,
              'santriTertinggi' => $santriTertinggi,
            'infaqLabels' => json_encode($infaqLabels),
            'infaqData' => json_encode($infaqData),
        ]);
    }
}
