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
        // Validasi input
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
        ]);

        // Simpan data penarikan
        $tabungan = new Tabungan();
        $tabungan->santri_id = $request->santri_id;
        $tabungan->tanggal = $request->tanggal;
        $tabungan->jumlah = $request->jumlah;
        $tabungan->jenis = 'penarikan';
        $tabungan->keterangan = $request->keterangan;
        $tabungan->save();

        return redirect()->back()->with('success', 'Penarikan berhasil dilakukan');
    }

    public function detail($santriId)
    {
        $santri = Santri::findOrFail($santriId);
        $tabungans = $santri->tabungans;

        return response()->json([
            'success' => true,
            'data' => $tabungans
        ]);
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
    
    

}
