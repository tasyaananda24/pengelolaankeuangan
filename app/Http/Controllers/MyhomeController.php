<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Infaq;
use Illuminate\Support\Facades\DB;
use App\Models\Tabungan;
use App\Models\TransaksiKas;

class MyhomeController extends Controller
{
    public function index()
{
    $bulanIni = now()->month;
    $tahunIni = now()->year;

    $totalSantri = Santri::count();

    $totalInfaqBulanIni = Infaq::whereMonth('tanggal', $bulanIni)
                                ->whereYear('tanggal', $tahunIni)
                                ->sum('jumlah');

    $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // === INFAQ ===
    $infaqBulanan = Infaq::selectRaw("MONTH(tanggal) as bulan, SUM(jumlah) as total")
        ->whereYear('tanggal', $tahunIni)
        ->groupByRaw("MONTH(tanggal)")
        ->get()
        ->keyBy('bulan');

    $infaqData = [];
    for ($i = 1; $i <= 12; $i++) {
        $infaqData[] = $infaqBulanan[$i]->total ?? 0;
    }

    // === TABUNGAN ===
    $tabunganBulanan = Tabungan::selectRaw("MONTH(tanggal) as bulan, SUM(CASE WHEN jenis = 'setoran' THEN jumlah ELSE 0 END) - SUM(CASE WHEN jenis = 'penarikan' THEN jumlah ELSE 0 END) as saldo")
        ->whereYear('tanggal', $tahunIni)
        ->groupByRaw("MONTH(tanggal)")
        ->get()
        ->keyBy('bulan');

    $tabunganData = [];
    for ($i = 1; $i <= 12; $i++) {
        $tabunganData[] = $tabunganBulanan[$i]->saldo ?? 0;
    }

    // === TOTAL TABUNGAN ===
    $totalTabungan = Tabungan::selectRaw("
        SUM(CASE WHEN jenis = 'setoran' THEN jumlah ELSE 0 END) - 
        SUM(CASE WHEN jenis = 'penarikan' THEN jumlah ELSE 0 END)
    AS saldo")->value('saldo');

    // === KAS ===
    $totalDebitKas = TransaksiKas::where('jenis', 'debit')->sum('jumlah');
    $totalKreditKas = TransaksiKas::where('jenis', 'kredit')->sum('jumlah');

    $kasDebit = TransaksiKas::selectRaw("MONTH(tanggal) as bulan, SUM(jumlah) as total")
        ->whereYear('tanggal', $tahunIni)
        ->where('jenis', 'debit')
        ->groupByRaw("MONTH(tanggal)")
        ->get()
        ->keyBy('bulan');

    $kasKredit = TransaksiKas::selectRaw("MONTH(tanggal) as bulan, SUM(jumlah) as total")
        ->whereYear('tanggal', $tahunIni)
        ->where('jenis', 'kredit')
        ->groupByRaw("MONTH(tanggal)")
        ->get()
        ->keyBy('bulan');

    $kasDebitData = [];
    $kasKreditData = [];
    for ($i = 1; $i <= 12; $i++) {
        $kasDebitData[] = $kasDebit[$i]->total ?? 0;
        $kasKreditData[] = $kasKredit[$i]->total ?? 0;
    }

    // === SANTRI TABUNGAN TERTINGGI ===
    $santriTabunganTertinggi = DB::table('tabungans')
        ->select('santris.nama', DB::raw("
            SUM(CASE WHEN tabungans.jenis = 'setoran' THEN jumlah ELSE 0 END) - 
            SUM(CASE WHEN tabungans.jenis = 'penarikan' THEN jumlah ELSE 0 END) as saldo
        "))
        ->join('santris', 'tabungans.santri_id', '=', 'santris.id')
        ->groupBy('tabungans.santri_id', 'santris.nama')
        ->orderByDesc('saldo')
        ->limit(1)
        ->first();

    return view('dashboard.bendahara', [
        'totalSantri' => $totalSantri,
        'totalInfaqBulanIni' => $totalInfaqBulanIni,
        'totalTabungan' => $totalTabungan,
        'totalDebitKas' => $totalDebitKas,
        'totalKreditKas' => $totalKreditKas,
        'santriTabunganTertinggi' => $santriTabunganTertinggi,

        // Grafik Infaq
        'infaqLabels' => json_encode($bulanLabels),
        'infaqData' => json_encode($infaqData),

        // Grafik Tabungan
        'tabunganLabels' => json_encode($bulanLabels),
        'tabunganData' => json_encode($tabunganData),

        // Grafik Kas
        'kasLabels' => json_encode($bulanLabels),
        'kasDebit' => json_encode($kasDebitData),
        'kasKredit' => json_encode($kasKreditData),
    ]);
}

}
