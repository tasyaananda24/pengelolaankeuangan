<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Infaq;
use Illuminate\Support\Facades\DB;

class MyhomeController extends Controller
{
    public function index()
    {
        // Ambil jumlah total santri dari tabel 'santris'
        $totalSantri = Santri::count();

        // Hitung total infaq bulan ini
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $totalInfaqBulanIni = Infaq::whereMonth('tanggal', $bulanIni)
                                    ->whereYear('tanggal', $tahunIni)
                                    ->sum('jumlah');

        // Ambil data infaq per bulan dalam tahun ini
        $infaqBulanan = Infaq::select(
                DB::raw("MONTH(tanggal) as bulan"),
                DB::raw("SUM(jumlah) as total")
            )
            ->whereYear('tanggal', $tahunIni)
            ->groupBy(DB::raw("MONTH(tanggal)"))
            ->orderBy(DB::raw("MONTH(tanggal)"))
            ->get();

        // Format data untuk chart
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = array_fill(0, 12, 0); // isi default 0

        foreach ($infaqBulanan as $item) {
            $index = $item->bulan - 1;
            $data[$index] = $item->total;
        }

        return view('dashboard/bendahara', [
            'totalSantri' => $totalSantri,
            'totalInfaqBulanIni' => $totalInfaqBulanIni,
            'infaqLabels' => json_encode($bulanLabels),
            'infaqData' => json_encode($data),

        ]);
        
    }
    
}
