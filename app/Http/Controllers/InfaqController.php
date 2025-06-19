<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\Santri;
use App\Models\SettingInfaq;
use App\Models\TransaksiKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InfaqController extends Controller
{
 public function index(Request $request)
{
    $search = $request->search;
    $tahunDipilih = $request->tahun ?? Carbon::now()->year;

    // Ambil data santri + relasi infaq (filtered by tahun)
    $santris = Santri::query()
        ->when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%");
        })
        ->with(['infaq' => function ($query) use ($tahunDipilih) {
            $query->whereYear('tanggal', $tahunDipilih);
        }])
        ->get();

    // Set locale Carbon
    Carbon::setLocale('id');

    // Buat daftar bulan Y-m (2025-01, 2025-02, dst) untuk tahun terpilih
    $bulanUnik = collect();
    $bulanLabel = collect();
    for ($i = 1; $i <= 12; $i++) {
        $date = Carbon::createFromDate($tahunDipilih, $i, 1);
        $bulanUnik->push($date->format('Y-m'));
        $bulanLabel->push($date->translatedFormat('F Y'));
    }

    // Jumlah default dari setting
    $jumlahDefault = SettingInfaq::latest()->value('jumlah') ?? 20000;

    // Daftar tahun untuk dropdown (2025–2040)
    $tahunList = range(2025, 2040);

    // === Setting Infaq: filter bulan & tahun ===
    $bulanSetting = $request->bulanSetting;
    $tahunSetting = $request->tahunSetting;

    $settingInfaqQuery = SettingInfaq::query();

    if ($bulanSetting) {
        $settingInfaqQuery->whereMonth('bulan', $bulanSetting);
    }

    if ($tahunSetting) {
        $settingInfaqQuery->whereYear('bulan', $tahunSetting);
    }

    // Jika tidak ada filter, tampilkan hanya bulan terbaru
    if (!$bulanSetting && !$tahunSetting) {
        $latestBulan = SettingInfaq::max('bulan');
        if ($latestBulan) {
            $settingInfaqQuery->where('bulan', $latestBulan);
        }
    }

    $settingInfaq = $settingInfaqQuery->orderBy('bulan', 'desc')->get();

    return view('infaq.index', compact(
        'santris',
        'bulanUnik',
        'bulanLabel',
        'jumlahDefault',
        'tahunList',
        'tahunDipilih',
        'settingInfaq'
    ));
}

    public function create()
    {
        $santris = Santri::all();
        return view('infaq.create', compact('santris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'bulan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Cegah duplikasi infaq per bulan per santri
        $existing = Infaq::where('santri_id', $request->santri_id)
            ->where('bulan', $request->bulan)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Santri ini sudah membayar infaq bulan tersebut.');
        }

        $infaq = Infaq::create([
            'santri_id' => $request->santri_id,
            'bulan' => $request->bulan,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        TransaksiKas::create([
            'tanggal' => $request->tanggal,
            'keterangan' => 'Infaq Santri ID ' . $request->santri_id . ($request->keterangan ? ' - ' . $request->keterangan : ''),
            'jumlah' => $request->jumlah,
            'jenis' => 'debit',
        ]);

        return redirect()->back()->with('success', 'Data infaq berhasil disimpan.');
    }

    public function edit($id)
    {
        $infaq = Infaq::findOrFail($id);
        $santris = Santri::all();
        return view('infaq.edit', compact('infaq', 'santris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'bulan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $infaq = Infaq::findOrFail($id);
        $infaq->update($request->all());

        return redirect()->route('infaq.index')->with('success', 'Infaq berhasil diperbarui');
    }

    public function destroy($id)
    {
        $infaq = Infaq::findOrFail($id);
        $infaq->delete();

        return redirect()->route('infaq.index')->with('success', 'Infaq berhasil dihapus');
    }

    public function export(Request $request)
    {
        $search = $request->search;

        $santris = Santri::with('infaq')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })->get();

        $bulanUnik = Infaq::selectRaw('DATE_FORMAT(tanggal, "%Y-%m-01") as bulan')
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan');

        $bulanLabel = $bulanUnik->map(function ($bln) {
            return Carbon::parse($bln)->translatedFormat('F Y');
        });

        $pdf = Pdf::loadView('infaq.export-pdf', compact('santris', 'bulanUnik', 'bulanLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Infaq-Bulanan.pdf');
    }

    // Fitur untuk menandai infaq sudah dibayar tanpa form manual
    public function tandaiSudahBayar(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'bulan' => 'required|string',
        ]);

        $tanggal = Carbon::createFromFormat('F Y', $request->bulan)->startOfMonth();
        $jumlah = SettingInfaq::latest()->value('jumlah') ?? 20000;

        $exists = Infaq::where('santri_id', $request->santri_id)
            ->where('bulan', $request->bulan)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Sudah tercatat.'], 409);
        }

        Infaq::create([
            'santri_id' => $request->santri_id,
            'bulan' => $request->bulan,
            'tanggal' => $tanggal->toDateString(),
            'jumlah' => $jumlah,
            'keterangan' => 'Ditandai manual oleh bendahara',
        ]);

        TransaksiKas::create([
            'tanggal' => $tanggal,
            'keterangan' => 'Infaq dari Santri ID ' . $request->santri_id,
            'jumlah' => $jumlah,
            'jenis' => 'debit',
        ]);

        return response()->json(['message' => 'Infaq berhasil ditandai.']);
    }
    // use App\Models\SettingInfaq; pastikan ini ada di atas jika belum

public function storeSetting(Request $request)
{
    $request->validate([
        'bulan' => 'required|date_format:Y-m',
        'jumlah' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string|max:255',
    ]);

    // Cek apakah setting untuk bulan ini sudah ada
    $existing = SettingInfaq::where('bulan', $request->bulan)->first();
    if ($existing) {
        return redirect()->back()->with('success', 'Setting untuk bulan ini sudah pernah disimpan.');
    }

    SettingInfaq::create([
        'bulan' => $request->bulan,
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->back()->with('success', 'Setting jumlah infaq berhasil disimpan.');
}
public function bayarInfaq(Request $request, $santri_id)
{
    $request->validate([
        'bulan' => 'required|date_format:Y-m',
    ]);

    $bulan = $request->bulan;

    $setting = SettingInfaq::where('bulan', $bulan)->first();
    if (!$setting) {
        return back()->with('error', 'Setting belum tersedia untuk bulan ini.');
    }

    $sudah = Infaq::where('santri_id', $santri_id)
        ->where('bulan', $bulan)
        ->first();

    if ($sudah) {
        return back()->with('error', 'Santri sudah bayar untuk bulan ini.');
    }

    $tanggalBayar = now();

    Infaq::create([
        'santri_id' => $santri_id,
        'tanggal' => $tanggalBayar,
        'jumlah' => $setting->jumlah,
        'bulan' => $bulan,
        'keterangan' => 'Bayar infaq bulan ' . \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y'),
    ]);

    TransaksiKas::create([
        'tanggal' => $tanggalBayar,
        'keterangan' => 'Pembayaran Infaq Santri ID ' . $santri_id,
        'jumlah' => $setting->jumlah,
        'jenis' => 'debit',
    ]);

    return back()->with('success', 'Pembayaran berhasil ditandai.');
}
public function batalInfaq($id)
{
    $infaq = Infaq::findOrFail($id);

    // Hapus juga dari transaksi kas jika ada
    TransaksiKas::where('tanggal', $infaq->tanggal)
        ->where('jumlah', $infaq->jumlah)
        ->where('keterangan', 'like', "%Santri ID {$infaq->santri_id}%")
        ->delete();

    $infaq->delete();

    return back()->with('success', 'Pembayaran berhasil dibatalkan.');
}
public function show($id)
{
    $santri = Santri::with('infaq')->findOrFail($id);
    return view('infaq.detail', compact('santri'));
}
public function download(Santri $santri, Request $request)
{
    $tahun = $request->get('tahun') ?? now()->year;
    
    $infaqs = $santri->infaq()->whereYear('tanggal', $tahun)->get();

    $pdf = PDF::loadView('infaq.cetak', compact('santri', 'infaqs', 'tahun'));

    return $pdf->download("Infaq_{$santri->nama}_{$tahun}.pdf");
}
public function destroySetting($id)
{
    $setting = SettingInfaq::findOrFail($id);
    $setting->delete();

    return redirect()->back()->with('success', 'Setting infaq berhasil dihapus.');
}


}
