<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModulAjar;
use App\Models\Guru;
use App\Models\MataPelajaran; // <-- Tambah ini
use Illuminate\Http\Request;

class BahanAjarController extends Controller
{
    public function index(Request $request)
    {
        $query = ModulAjar::with(['guru.user', 'guru.mataPelajaran']);

        // Filter Guru
        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        // Filter Mata Pelajaran (melalui relasi guru)
        if ($request->filled('mata_pelajaran_id')) {
            $query->whereHas('guru', function($q) use ($request) {
                $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);
            });
        }

        $bahanAjar = $query->orderBy('created_at', 'desc')->get();
        
        // Ambil data untuk dropdown
        $gurus = Guru::with('user')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get(); // <-- Tambah ini

        return view('admin.bahan-ajar', compact('bahanAjar', 'gurus', 'mataPelajarans'));
    }
}