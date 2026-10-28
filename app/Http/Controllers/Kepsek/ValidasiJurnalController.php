<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ValidasiJurnalController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data jurnal beserta relasinya
        $query = Journal::with(['guru.user', 'kelas', 'jadwal.mataPelajaran']);

        // Filter Kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter Status
        if ($request->filled('status_validasi')) {
            $query->where('status_validasi', $request->status_validasi);
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('kepsek.validasi-jurnal', compact('jurnals', 'kelas'));
    }

    public function show($id)
    {
        $jurnal = Journal::with(['guru.user', 'guruPendamping.user', 'kelas', 'jadwal.mataPelajaran'])
                         ->findOrFail($id);
        
        return view('kepsek.detail-validasi', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = Journal::findOrFail($id);

        $request->validate([
            'status_validasi' => 'required|in:valid,menunggu_revisi',
            'catatan_validasi' => 'nullable|string'
        ]);

        $jurnal->update([
            'status_validasi' => $request->status_validasi,
            'catatan_validasi' => $request->catatan_validasi,
            'validator_id' => auth()->id(),
            'validated_at' => now(),
        ]);

        return redirect()->route('kepsek.validasi-jurnal.index')
                         ->with('success', 'Jurnal berhasil diperbarui statusnya!');
    }
}