<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Infaq;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function kas(Request $request)
    {
        // Logika untuk menampilkan laporan kas
        return view('laporan.index')->with([
            'data_kas' => [] // Data laporan kas
        ]);
    }

    public function infaq(Request $request)
    {
        // Logika untuk menampilkan laporan infaq
        return view('laporan.index')->with([
            'data_infaq' => [] // Data laporan infaq
        ]);
    }

    public function cetakKas(Request $request)
    {
        // Logika untuk mencetak laporan kas
        return response()->json([
            'success' => true,
            'message' => 'Laporan kas berhasil dicetak'
        ]);
    }

    public function cetakInfaq(Request $request)
    {
        // Logika untuk mencetak laporan infaq
        return response()->json([
            'success' => true,
            'message' => 'Laporan infaq berhasil dicetak'
        ]);
    }
    public function laporanInfaq(Request $request)
    {
        $bulanParam = $request->get('bulan', date('Y-m'));
        $carbonBulan = Carbon::parse($bulanParam . '-01');

        $laporan = Infaq::select('santri_id', DB::raw('SUM(jumlah) as jumlah'))
            ->whereMonth('tanggal', $carbonBulan->month)
            ->whereYear('tanggal', $carbonBulan->year)
            ->groupBy('santri_id')
            ->with('santri') // pastikan relasi santri sudah ada di model Infaq
            ->get()
            ->map(function ($item) {
                return (object)[
                    'nama' => $item->santri->nama,
                    'jumlah' => $item->jumlah
                ];
            });

        $totalInfaq = $laporan->sum('jumlah');
        $bulanFormatted = $carbonBulan->translatedFormat('F Y');

        return view('laporan.laporan-infaq', [
            'laporan' => $laporan,
            'totalInfaq' => $totalInfaq,
            'bulanSelected' => $bulanFormatted,
        ]);
    }
} 