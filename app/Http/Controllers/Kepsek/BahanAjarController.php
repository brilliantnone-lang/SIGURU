<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\ModulAjar;
use App\Models\Guru;
use App\Models\MataPelajaran;
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

        // Filter Mata Pelajaran
        if ($request->filled('mata_pelajaran_id')) {
            $query->whereHas('guru', function($q) use ($request) {
                $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);
            });
        }

        $bahanAjar = $query->orderBy('created_at', 'desc')->get();
        
        $gurus = Guru::with('user')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();

        return view('kepsek.bahan-ajar', compact('bahanAjar', 'gurus', 'mataPelajarans'));
    }
}