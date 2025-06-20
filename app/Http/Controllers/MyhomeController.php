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
        $totalSantri = Santri::count();
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $totalInfaqBulanIni = Infaq::whereMonth('tanggal', $bulanIni)
                                    ->whereYear('tanggal', $tahunIni)
                                    ->sum('jumlah');

        $infaqBulanan = Infaq::selectRaw("MONTH(tanggal) as bulan, SUM(jumlah) as total")
            ->whereYear('tanggal', $tahunIni)
            ->groupByRaw("MONTH(tanggal)")
            ->orderByRaw("MONTH(tanggal)")
            ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $infaqData = array_fill(0, 12, 0);

        foreach ($infaqBulanan as $item) {
            $infaqData[$item->bulan - 1] = $item->total;
        }

        // Total Tabungan
        $totalTabungan = Tabungan::selectRaw("
            SUM(CASE WHEN jenis = 'setoran' THEN jumlah ELSE 0 END) -
            SUM(CASE WHEN jenis = 'penarikan' THEN jumlah ELSE 0 END)
        AS saldo")->value('saldo');

        // Total Kas (debit - kredit)
        $totalKas = TransaksiKas::selectRaw("
            SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) -
            SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END)
        AS saldo")->value('saldo') ?? 0;

        // Total Debit & Kredit
        $totalDebitKas = TransaksiKas::where('jenis', 'debit')->sum('jumlah') ?? 0;
        $totalKreditKas = TransaksiKas::where('jenis', 'kredit')->sum('jumlah') ?? 0;

        // Grafik Kas Bulanan
        $kasBulanan = TransaksiKas::selectRaw("
            MONTH(tanggal) as bulan,
            SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) -
            SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as saldo
        ")
        ->whereYear('tanggal', $tahunIni)
        ->groupByRaw("MONTH(tanggal)")
        ->orderByRaw("MONTH(tanggal)")
        ->get();

        $kasData = array_fill(0, 12, 0);
        foreach ($kasBulanan as $item) {
            $kasData[$item->bulan - 1] = $item->saldo;
        }

        // Santri dengan Tabungan Tertinggi
        $santriTabunganTertinggi = DB::table('tabungans')
            ->select('santris.nama', DB::raw("
                SUM(CASE WHEN tabungans.jenis = 'setoran' THEN jumlah ELSE 0 END) -
                SUM(CASE WHEN tabungans.jenis = 'penarikan' THEN jumlah ELSE 0 END) as saldo
            "))
            ->join('santris', 'tabungans.santri_id', '=', 'santris.id')
            ->groupBy('santri_id', 'santris.nama')
            ->orderByDesc('saldo')
            ->limit(1)
            ->first();

        return view('dashboard.bendahara', [
            'totalSantri' => $totalSantri,
            'totalInfaqBulanIni' => $totalInfaqBulanIni,
            'totalTabungan' => $totalTabungan,
            'totalKas' => $totalKas,
            'totalDebitKas' => $totalDebitKas,
            'totalKreditKas' => $totalKreditKas,
            'santriTabunganTertinggi' => $santriTabunganTertinggi,
            'infaqLabels' => json_encode($bulanLabels),
            'infaqData' => json_encode($infaqData),
            'kasLabels' => json_encode($bulanLabels),
            'kasData' => json_encode($kasData),
        ]);
    }
}
