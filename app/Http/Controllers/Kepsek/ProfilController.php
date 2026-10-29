<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('kepsek.profil', compact('user'));
    }

    public function updateTtd(Request $request)
    {
        $request->validate([
            'ttd_kepsek' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('ttd_kepsek')) {
            // Hapus TTD lama jika ada
            if ($user->ttd_kepsek && Storage::disk('public')->exists($user->ttd_kepsek)) {
                Storage::disk('public')->delete($user->ttd_kepsek);
            }

            $path = $request->file('ttd_kepsek')->store('ttd-kepsek', 'public');
            $user->update(['ttd_kepsek' => $path]);
        }

        return redirect()->route('kepsek.profil')->with('success', 'Tanda tangan berhasil diperbarui!');
    }
}