<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function show()
    {
        $user = Auth::user(); // Ambil data user yang login
        return view('profile.profile', compact('user'));
    }
    // File: app/Http/Controllers/ProfileController.php

public function edit()
{
    $user = auth()->user(); // atau sesuai dengan kebutuhan Anda
    return view('profile.edit', compact('user'));
}
public function update(Request $request)
{
    $user = auth()->user();

    // Validasi data yang dikirim
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        // Tambah validasi lainnya jika ada field lain
    ]);

    // Update user
    $user->update($validated);

    return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
}


}
