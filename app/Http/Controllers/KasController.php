<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKas;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KasController extends Controller
{
    // Fungsi bantu untuk menghitung saldo
    private function hitungSaldo()
    {
        $totalKredit = TransaksiKas::where('jenis', 'kredit')->sum('jumlah');
        $totalDebit = TransaksiKas::where('jenis', 'debit')->sum('jumlah');
        return $totalDebit - $totalKredit;
    }
    public function index(Request $request)
{
    $query = TransaksiKas::query();

    // Filter bulan dan tahun
    if ($request->filled('bulan') && $request->filled('tahun')) {
        $startDate = Carbon::createFromDate($request->tahun, $request->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $query->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
    } else {
        $latestTransaksi = TransaksiKas::orderBy('tanggal', 'desc')->first();

        if ($latestTransaksi) {
            $latestMonth = Carbon::parse($latestTransaksi->tanggal)->format('m');
            $latestYear = Carbon::parse($latestTransaksi->tanggal)->format('Y');

            $startDate = Carbon::createFromDate($latestYear, $latestMonth, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($latestYear, $latestMonth, 1)->endOfMonth();

            $query->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        }
    }

    // ✅ Tambahkan filter jenis transaksi
    if ($request->filled('jenis') && in_array($request->jenis, ['kredit', 'debit'])) {
        $query->where('jenis', $request->jenis);
    }

    $transaksi = $query->orderBy('tanggal', 'desc')->get();
    $saldo = $this->hitungSaldo();

    $transaksiGrouped = $transaksi->groupBy(function ($item) {
        return Carbon::parse($item->tanggal)->format('Y-m');
    });

    return view('kas.index', [
        'saldo' => $saldo,
        'transaksi' => $transaksiGrouped,
        'request' => $request, // supaya bisa akses data di blade
    ]);
    
}

        public function storeKredit(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pilihan' => 'required|string',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $saldo = $this->hitungSaldo();

        if ($request->jumlah > $saldo) {
            return redirect('/kas')->with('error', 'Saldo tidak mencukupi untuk melakukan transaksi pengeluaran.');
        }

        TransaksiKas::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => 'kredit', // kredit = pengeluaran
            'jenis_transaksi' => $request->pilihan,
        ]);

        return redirect('/kas')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function storeDebit(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pilihan' => 'required|string',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        TransaksiKas::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => 'debit', // debit = pemasukan
            'jenis_transaksi' => $request->pilihan,
        ]);

        return redirect('/kas')->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = TransaksiKas::findOrFail($id);
        return view('kas.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:kredit,debit',
            'jenis_transaksi' => 'nullable|string',
        ]);

        $transaksi = TransaksiKas::findOrFail($id);
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
            'jenis_transaksi' => $request->jenis_transaksi,
        ]);

        return redirect('/kas')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiKas::findOrFail($id);
        $transaksi->delete();

        return redirect('/kas')->with('success', 'Transaksi berhasil dihapus.');
    }
public function laporan(Request $request)
{
    $bulan = (int) $request->get('bulan', date('n'));
    $tahun = (int) $request->get('tahun', date('Y'));

    $transaksi = TransaksiKas::whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();

    return view('kas.laporan_kas', compact('transaksi', 'bulan', 'tahun'));
}


public function laporanKas(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $transaksi = TransaksiKas::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'asc')
                    ->get();

    return view('kas.laporan_kas', compact('transaksi', 'bulan', 'tahun'));
}
public function export(Request $request)
{
    $bulan = (int) $request->input('bulan', date('n'));
    $tahun = (int) $request->input('tahun', date('Y'));

    $transaksi = TransaksiKas::whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();

    $totalDebit = $transaksi->where('jenis', 'debit')->sum('jumlah');
    $totalKredit = $transaksi->where('jenis', 'kredit')->sum('jumlah');

    $pdf = PDF::loadView('laporan.kas_pdf', [
        'transaksi' => $transaksi,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'totalDebit' => $totalDebit,
        'totalKredit' => $totalKredit,
        'saldoAkhir' => $totalDebit - $totalKredit,
    ]);

    $namaBulan = \Carbon\Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

    return $pdf->stream("Laporan-Kas-{$namaBulan}-{$tahun}.pdf");
}


}
