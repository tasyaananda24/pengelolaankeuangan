<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'Aktif');
        $search = $request->query('search');

        $query = Santri::query();

        if ($status !== 'Semua') {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $santris = $query->orderBy('nama')->paginate(10);

        return view('santri.index', compact('santris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ortu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $lastSantri = Santri::orderByDesc('id')->first();

        $lastNumber = 0;
        if ($lastSantri && $lastSantri->kode_santri) {
            $lastNumber = (int) substr($lastSantri->kode_santri, 2);
        }

        $newKode = 'KS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $validated['kode_santri'] = $newKode;

        Santri::create($validated);

        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan');
    }

    public function edit(Santri $santri)
    {
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required',
        'nama_ortu' => 'required',
        'no_hp' => 'required',
        'status' => 'required|in:Aktif,Tidak Aktif',
    ]);

    $santri = Santri::findOrFail($id);

    $santri->update([
        'nama' => $request->nama,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'nama_ortu' => $request->nama_ortu,
        'no_hp' => $request->no_hp,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Data santri berhasil diperbarui.');
}


    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Santri berhasil dihapus');
    }

    public function show($id)
    {
        $santri = Santri::findOrFail($id);
        return view('santri.show', compact('santri'));
    }

    public function generateKode()
    {
        $lastSantri = Santri::orderByDesc('id')->first();
        $lastNumber = 0;
        if ($lastSantri && $lastSantri->kode_santri) {
            $lastNumber = (int) substr($lastSantri->kode_santri, 2);
        }
        $newKode = 'KS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return response()->json(['kode' => $newKode]);
    }
}
