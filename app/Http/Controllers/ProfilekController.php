<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfilekController extends Controller
{
    // Tampilkan profil ketua
     public function show()
    {
        $user = Auth::user(); // Ambil data user yang login
        return view('profileketua.profile', compact('user'));
    }

    // Tampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profileketua.edit', compact('user'));
    }

    // Proses update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // Tambahkan validasi lain jika perlu, misalnya email atau no_hp
        ]);

        $user->name = $request->name;
        // Tambah field lain sesuai kebutuhan, contoh:
        // $user->email = $request->email;

        $user->save();

        return redirect()->route('profileketua.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
