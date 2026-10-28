<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Guru;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar beserta relasi
        $query = Journal::with(['guru.user', 'guruPendamping.user', 'kelas', 'jadwal.mataPelajaran']);

        // Filter berdasarkan Guru
        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        // Filter berdasarkan Status Validasi
        if ($request->filled('status_validasi')) {
            $query->where('status_validasi', $request->status_validasi);
        }

        // Ambil data jurnal terbaru
        $jurnals = $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai_ke', 'asc')->get();
        
        // Ambil data guru untuk dropdown filter
        $gurus = Guru::with('user')->get();

        return view('admin.jurnal', compact('jurnals', 'gurus'));
    }
}