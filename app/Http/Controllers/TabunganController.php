<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class TabunganController extends Controller
{
    public function index()
    {
        // Ambil semua santri beserta tabungannya
        $santris = Santri::with('tabungans')->get();
        return view('tabungan.index', compact('santris'));
    }

    public function setoran(Request $request)
    {
        // Validasi input
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
        ]);

        // Simpan data setoran
        $tabungan = new Tabungan();
        $tabungan->santri_id = $request->santri_id;
        $tabungan->tanggal = $request->tanggal;
        $tabungan->jumlah = $request->jumlah;
        $tabungan->jenis = 'setoran';
        $tabungan->keterangan = $request->keterangan;
        $tabungan->save();

        return redirect()->back()->with('success', 'Setoran berhasil ditambahkan');
    }

    public function penarikan(Request $request)
{
    $request->validate([
        'santri_id' => 'required|exists:santris,id',
        'tanggal' => 'required|date',
        'jumlah' => 'required|numeric|min:1',
        'keterangan' => 'required|string',
    ]);

    $santri = Santri::with('tabungans')->findOrFail($request->santri_id);
    $setoran = $santri->tabungans->where('jenis', 'setoran')->sum('jumlah');
    $penarikan = $santri->tabungans->where('jenis', 'penarikan')->sum('jumlah');
    $saldo = $setoran - $penarikan;

    if ($request->jumlah > $saldo) {
        return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan.');
    }

    Tabungan::create([
        'santri_id' => $request->santri_id,
        'tanggal' => $request->tanggal,
        'jumlah' => $request->jumlah,
        'jenis' => 'penarikan',
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->back()->with('success', 'Penarikan berhasil disimpan.');
}


   public function detail($id, Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $query = Tabungan::where('santri_id', $id);

    if ($bulan) {
        $query->whereMonth('tanggal', $bulan);
    }
    if ($tahun) {
        $query->whereYear('tanggal', $tahun);
    }

    $data = $query->orderBy('tanggal')->get();

    return response()->json(['success' => true, 'data' => $data]);
}


    public function edit(Request $request, $id)
    {
        $tabungan = Tabungan::find($id);
        if (!$tabungan) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }

        $tabungan->tanggal = $request->tanggal;
        $tabungan->jenis = $request->jenis;
        $tabungan->jumlah = $request->jumlah;
        $tabungan->keterangan = $request->keterangan;
        $tabungan->save();

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui']);
    }

    public function hapus($id)
    {
        $tabungan = Tabungan::find($id);
        if (!$tabungan) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }

        $tabungan->delete();
        return response()->json(['success' => true, 'message' => 'Transaksi berhasil dihapus']);
    }

    public function getTransaksi($id)
    {
        $tabungan = Tabungan::find($id);
        if ($tabungan) {
            return response()->json(['success' => true, 'data' => $tabungan]);
        } else {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
        }
    }
    public function cetak($id)
    {
        // Mengambil data santri beserta tabungannya
        $santri = Santri::with('tabungans')->findOrFail($id);
        
        // Menggunakan PDF untuk menghasilkan file PDF
        $pdf = Pdf::loadView('tabungan.cetak', compact('santri'));
        
        // Mengembalikan PDF yang dihasilkan ke browser
        return $pdf->stream('Laporan_Tabungan_'.$santri->nama.'.pdf');
    }
    public function updateTransaksi(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|numeric|min:1',
        'keterangan' => 'required|string|max:255',
    ]);

    $transaksi = Tabungan::find($id);
    if (!$transaksi) {
        return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
    }

    $transaksi->jumlah = $request->jumlah;
    $transaksi->keterangan = $request->keterangan;
    $transaksi->save();

    return response()->json(['success' => true, 'message' => 'Berhasil diperbarui']);
}

    

}
