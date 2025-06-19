<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;

class DataSantriController extends Controller
{
    public function index()
    {
        $santris = Santri::all();
        return view('datasantri.index', compact('santris'));
    }

    public function create()
    {
        return view('datasantri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required|numeric',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        Santri::create($request->all());
        return redirect('/kelola-santri')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        return view('datasantri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required|numeric',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $santri->update($request->all());
        return redirect('/kelola-santri')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();
         return response()->json(['success' => true, 'message' => 'Data santri berhasil dihapus.']);
    }
    public function laporan()
{
    $santris = Santri::orderBy('nama')->get();
    return view('santri.laporan', compact('santris'));
}

}
