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

    // Filter berdasarkan status jika bukan 'Semua'
    if ($status !== 'Semua') {
        $query->where('status', $status);
    }

    // Filter berdasarkan pencarian nama jika ada input
    if (!empty($search)) {
        $query->where('nama', 'like', '%' . $search . '%');
    }

    $santris = $query->get();

    return view('santri.index', compact('santris'));
}


    public function store(Request $request)
    {
        // Validasi input, tambahkan kolom status
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ortu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Santri::create($validated);

        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan');
    }

    public function edit(Santri $santri)
    {
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        // Validasi input, tambahkan kolom status
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nama_ortu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $santri->update($validated);

        return redirect()->route('santri.index')->with('success', 'Santri berhasil diperbarui');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Santri berhasil dihapus');
    }
}
