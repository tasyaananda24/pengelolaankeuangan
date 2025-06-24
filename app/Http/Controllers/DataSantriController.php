<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
class DataSantriController extends Controller
{

    public function laporan()
{
    $santris = Santri::orderBy('nama')->get();
    return view('santri.laporan', compact('santris'));
}
    public function cetakPdf()
{
    $santris = Santri::all(); // atau sesuai dengan model dan logika kamu
    $pdf = PDF::loadView('santri.laporan-pdf', compact('santris'));
    return $pdf->download('laporan-data-santri.pdf');
}

}
