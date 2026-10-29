<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // 1. Halaman Lihat Profil
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::with('mataPelajaran')->where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('guru.dashboard')->with('error', 'Data profil guru tidak ditemukan.');
        }

        return view('guru.profil-saya', compact('user', 'guru'));
    }

    // 2. Halaman Edit Profil
    public function edit()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        $mataPelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();

        return view('guru.edit-profil', compact('user', 'guru', 'mataPelajarans'));
    }

    // 3. Proses Update Profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nip_guru' => 'required|string|unique:guru,nip_guru,' . $guru->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'password' => 'nullable|string|min:6',
        ]);

        // Update tabel Users
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        // Update Password (jika diisi)
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update tabel Guru
        $guru->update([
            'nip_guru' => $request->nip_guru,
            'nomor_telepon' => $request->nomor_telepon,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        return redirect()->route('guru.profil-saya')
                         ->with('success', 'Profil berhasil diperbarui!');
    }
}