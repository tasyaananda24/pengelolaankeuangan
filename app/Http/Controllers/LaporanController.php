<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Infaq;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Santri;
class LaporanController extends Controller
{
    public function index()
    {
        return view ('laporan.index');
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
    $tahun = $request->get('tahun', now()->year);

    // Ambil total infaq per bulan dalam tahun yang dipilih
    $infaqPerBulan = Infaq::where('bulan', 'like', "$tahun-%")
        ->get()
        ->groupBy('bulan')
        ->map(function ($items) {
            return $items->sum('jumlah');
        });

    // Total keseluruhan
    $totalKeseluruhan = $infaqPerBulan->sum();

    // Ambil list tahun dari isi kolom bulan
    $tahunList = Infaq::selectRaw("SUBSTRING(bulan, 1, 4) as tahun")
        ->distinct()
        ->pluck('tahun')
        ->sortDesc();

    return view('laporan.infaq', compact('infaqPerBulan', 'totalKeseluruhan', 'tahun', 'tahunList'));
}
public function laporanInfaqPdf($tahun)
{
    $infaqPerBulan = Infaq::where('bulan', 'like', "$tahun-%")
        ->get()
        ->groupBy('bulan')
        ->map(fn($items) => $items->sum('jumlah'));

    $totalKeseluruhan = $infaqPerBulan->sum();

    $bulanNama = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    $pdf = Pdf::loadView('laporan.infaq_pdf', compact('tahun', 'infaqPerBulan', 'totalKeseluruhan', 'bulanNama'));
    return $pdf->stream("laporan-infaq-$tahun.pdf");
}
public function exportPDF()
{
    $santris = Santri::all(); // Atau filter sesuai kebutuhan
    $pdf = Pdf::loadView('laporan.santri_pdf', compact('santris'))->setPaper('A4', 'portrait');
    return $pdf->download('Laporan_Santri_TPQ_ASAAFA.pdf');
}
}
