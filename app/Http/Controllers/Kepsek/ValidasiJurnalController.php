<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\CoverJurnal;
use App\Models\Guru;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ValidasiJurnalController extends Controller
{
    public function index()
    {
        $covers = CoverJurnal::orderBy('tahun_ajaran', 'desc')
                             ->orderBy('semester', 'asc')
                             ->get();

        $hariIni = Carbon::now();
        foreach ($covers as $cover) {
            $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
                                        ->where('semester', $cover->semester)
                                        ->first();
            
            if ($kalender && $hariIni->gt(Carbon::parse($kalender->tanggal_selesai))) {
                $cover->status_berjalan = false;
            } else {
                $cover->status_berjalan = true;
            }
        }

        return view('kepsek.validasi-jurnal', compact('covers'));
    }

    public function show($id)
    {
        $cover = CoverJurnal::findOrFail($id);
        
        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
                                    ->where('semester', $cover->semester)
                                    ->first();
        $hariIni = Carbon::now();
        $isSelesai = false;
        if ($kalender && $hariIni->gt(Carbon::parse($kalender->tanggal_selesai))) {
            $isSelesai = true;
        }

        // Ambil guru + jumlah jurnal + status keseluruhan
        $gurus = Guru::with('user', 'mataPelajaran')
            ->whereHas('journal', function($q) use ($id) {
                $q->where('cover_jurnal_id', $id);
            })
            ->withCount(['journal' => function($q) use ($id) {
                $q->where('cover_jurnal_id', $id);
            }])
            ->get();

        // Hitung status keseluruhan per guru
        foreach ($gurus as $guru) {
            $jurnals = Journal::where('cover_jurnal_id', $id)
                              ->where('guru_id', $guru->id)
                              ->get();

            if ($jurnals->isEmpty()) {
                $guru->status_keseluruhan = 'kosong';
            } elseif ($jurnals->every(fn($j) => $j->status_validasi === 'valid')) {
                $guru->status_keseluruhan = 'valid';
            } elseif ($jurnals->contains(fn($j) => $j->status_validasi === 'menunggu_revisi')) {
                $guru->status_keseluruhan = 'menunggu_revisi';
            } else {
                $guru->status_keseluruhan = 'belum_valid';
            }
        }

        return view('kepsek.detail-validasi', compact('cover', 'gurus', 'isSelesai'));
    }

    public function jurnalGuru($cover_id, $guru_id)
    {
        $cover = CoverJurnal::findOrFail($cover_id);
        $guru = Guru::with('user', 'mataPelajaran')->findOrFail($guru_id);

        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
                                    ->where('semester', $cover->semester)
                                    ->first();
        $hariIni = Carbon::now();
        $isSelesai = false;
        if ($kalender && $hariIni->gt(Carbon::parse($kalender->tanggal_selesai))) {
            $isSelesai = true;
        }

        $jurnals = Journal::with(['kelas', 'jadwal.mataPelajaran'])
                          ->where('cover_jurnal_id', $cover_id)
                          ->where('guru_id', $guru_id)
                          ->orderBy('tanggal', 'asc')
                          ->get();

        // Hitung status keseluruhan
        $statusUtama = 'belum_valid';
        if ($jurnals->isNotEmpty()) {
            if ($jurnals->every(fn($j) => $j->status_validasi === 'valid')) {
                $statusUtama = 'valid';
            } elseif ($jurnals->contains(fn($j) => $j->status_validasi === 'menunggu_revisi')) {
                $statusUtama = 'menunggu_revisi';
            }
        }

        return view('kepsek.jurnal-guru', compact('cover', 'guru', 'jurnals', 'isSelesai', 'statusUtama'));
    }

    public function validasiGuru(Request $request, $cover_id, $guru_id)
    {
        $cover = CoverJurnal::findOrFail($cover_id);
        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
                                    ->where('semester', $cover->semester)
                                    ->first();
        $hariIni = Carbon::now();
        if (!$kalender || $hariIni->lte(Carbon::parse($kalender->tanggal_selesai))) {
            return redirect()->back()->with('error', 'Semester ini masih berjalan. Validasi hanya bisa dilakukan setelah semester selesai.');
        }

        $request->validate([
            'status_validasi' => 'required|in:valid,menunggu_revisi',
            'catatan_validasi' => 'nullable|string'
        ]);

        Journal::where('cover_jurnal_id', $cover_id)
               ->where('guru_id', $guru_id)
               ->update([
                   'status_validasi' => $request->status_validasi,
                   'catatan_validasi' => $request->catatan_validasi,
                   'validator_id' => auth()->id(),
                   'validated_at' => now(),
               ]);

        return redirect()->route('kepsek.validasi-jurnal.show', $cover_id)
                         ->with('success', 'Validasi berhasil diproses.');
    }

    public function detailJurnal($id)
    {
        $jurnal = Journal::with(['guru.user', 'guruPendamping.user', 'kelas', 'jadwal.mataPelajaran'])
                         ->findOrFail($id);
        
        return view('kepsek.detail-jurnal', compact('jurnal'));
    }
}