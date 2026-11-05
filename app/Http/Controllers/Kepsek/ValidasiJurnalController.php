<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\CoverJurnal;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ValidasiJurnalController extends Controller
{
    // 1. List Semester
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
                $cover->status_berjalan = false; // Selesai
            } else {
                $cover->status_berjalan = true; // Berjalan
            }
        }

        return view('kepsek.validasi-jurnal', compact('covers'));
    }

    // 2. List Guru dalam 1 Semester
    public function show($id)
    {
        $cover = CoverJurnal::findOrFail($id);

        // Cek apakah semester sudah selesai
        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
            ->where('semester', $cover->semester)
            ->first();
        $hariIni = Carbon::now();
        $isSelesai = false;
        if ($kalender && $hariIni->gt(Carbon::parse($kalender->tanggal_selesai))) {
            $isSelesai = true;
        }

        // Ambil guru yang punya jurnal di semester ini
        $gurus = Guru::with('user', 'mataPelajaran')
            ->whereHas('journal', function ($q) use ($id) {
                $q->where('cover_jurnal_id', $id);
            })
            ->withCount(['journal' => function ($q) use ($id) {
                $q->where('cover_jurnal_id', $id);
            }])
            ->get();

        // --- HITUNG STATUS KESELURUHAN PER GURU ---
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
            } elseif ($jurnals->contains(fn($j) => $j->status_validasi === 'sudah_revisi')) {
                $guru->status_keseluruhan = 'sudah_revisi';
            } else {
                $guru->status_keseluruhan = 'belum_valid';
            }
        }
        // ------------------------------------------

        return view('kepsek.detail-validasi', compact('cover', 'gurus', 'isSelesai'));
    }

    // 3. Halaman Detail Jurnal Per Guru + Form Validasi
    public function jurnalGuru($cover_id, $guru_id)
    {
        $cover = CoverJurnal::findOrFail($cover_id);
        $guru = Guru::with('user', 'mataPelajaran')->findOrFail($guru_id);

        // Cek status semester
        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
            ->where('semester', $cover->semester)
            ->first();
        $hariIni = Carbon::now();
        $isSelesai = false;
        if ($kalender && $hariIni->gt(Carbon::parse($kalender->tanggal_selesai))) {
            $isSelesai = true;
        }

        // Ambil jurnal
        $jurnals = Journal::with(['kelas', 'jadwal.mataPelajaran'])
            ->where('cover_jurnal_id', $cover_id)
            ->where('guru_id', $guru_id)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Cek kelengkapan jurnal
        $cek = $this->cekKelengkapanJurnal($cover, $guru);
        $isLengkap = $cek['lengkap'];
        $target = $cek['target'];
        $terisi = $cek['terisi'];

        // --- TAMBAHKAN INI: Hitung status keseluruhan untuk badge ---
        $statusUtama = 'belum_valid';
        if ($jurnals->isNotEmpty()) {
            if ($jurnals->every(fn($j) => $j->status_validasi === 'valid')) {
                $statusUtama = 'valid';
            } elseif ($jurnals->contains(fn($j) => $j->status_validasi === 'menunggu_revisi')) {
                $statusUtama = 'menunggu_revisi';
            } elseif ($jurnals->contains(fn($j) => $j->status_validasi === 'sudah_revisi')) {
                $statusUtama = 'sudah_revisi';
            }
        }
        // -----------------------------------------------------------

        return view('kepsek.jurnal-guru', compact(
            'cover',
            'guru',
            'jurnals',
            'isSelesai',
            'isLengkap',
            'target',
            'terisi',
            'statusUtama'
        ));
    }

    public function validasiGuru(Request $request, $cover_id, $guru_id)
    {
        // 1. Cek semester selesai
        $cover = CoverJurnal::findOrFail($cover_id);
        $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
            ->where('semester', $cover->semester)
            ->first();
        $hariIni = Carbon::now();
        if (!$kalender || $hariIni->lte(Carbon::parse($kalender->tanggal_selesai))) {
            return redirect()->back()->with('error', 'Semester ini masih berjalan.');
        }

        // 2. Cek kelengkapan jurnal
        $guru = Guru::findOrFail($guru_id);
        $cek = $this->cekKelengkapanJurnal($cover, $guru);
        if (!$cek['lengkap']) {
            return redirect()->back()->with('error', 'Jurnal guru ini belum lengkap. Terisi ' . $cek['terisi'] . ' dari target ' . $cek['target'] . '.');
        }

        // 3. Validasi input
        $request->validate([
            'status_validasi' => 'required|in:valid,menunggu_revisi',
            'catatan_validasi' => 'nullable|string'
        ]);

        // 4. Update semua jurnal guru di semester ini
        Journal::where('cover_jurnal_id', $cover_id)
            ->where('guru_id', $guru_id)
            ->update([
                'status_validasi' => $request->status_validasi,
                'catatan_validasi' => $request->catatan_validasi,
                'validator_id' => auth()->id(),
                'validated_at' => now(),
            ]);

        $pesan = $request->status_validasi === 'valid'
            ? 'Semua jurnal ' . $guru->user->name . ' berhasil divalidasi!'
            : 'Semua jurnal ' . $guru->user->name . ' ditandai untuk revisi.';

        return redirect()->route('kepsek.validasi-jurnal.show', $cover_id)
            ->with('success', $pesan);
    }

    // 5. Detail Per Jurnal (TTD)
    public function detailJurnal($id)
    {
        $jurnal = Journal::with(['guru.user', 'guruPendamping.user', 'kelas', 'jadwal.mataPelajaran'])
            ->findOrFail($id);

        return view('kepsek.detail-jurnal', compact('jurnal'));
    }

    // 6. Fungsi Bantu: Cek Kelengkapan Jurnal
    private function cekKelengkapanJurnal($cover, $guru)
    {
        $mulai = Carbon::parse($cover->tanggal_mulai ?? null);
        $selesai = Carbon::parse($cover->tanggal_selesai ?? null);

        // Fallback ke Kalender Akademik jika cover tidak punya tanggal
        if (!$mulai || !$selesai) {
            $kalender = KalenderAkademik::where('tahun_ajaran', $cover->tahun_ajaran)
                ->where('semester', $cover->semester)
                ->first();
            if ($kalender) {
                $mulai = Carbon::parse($kalender->tanggal_mulai);
                $selesai = Carbon::parse($kalender->tanggal_selesai);
            }
        }

        if (!$mulai || !$selesai) return ['lengkap' => false, 'target' => 0, 'terisi' => 0];

        // Hitung target pertemuan
        $semuaJadwal = Jadwal::where('guru_id', $guru->id)->get();
        $target = 0;
        foreach ($semuaJadwal as $jadwal) {
            $indexHari = [
                'senin' => 1,
                'selasa' => 2,
                'rabu' => 3,
                'kamis' => 4,
                'jumat' => 5,
                'sabtu' => 6
            ][$jadwal->hari] ?? 1;

            $current = $mulai->copy();
            while ($current->lte($selesai)) {
                if ($current->dayOfWeek === $indexHari) {
                    $target++;
                }
                $current->addDay();
            }
        }

        $terisi = Journal::where('guru_id', $guru->id)
            ->where('cover_jurnal_id', $cover->id)
            ->count();

        return [
            'lengkap' => $terisi >= $target,
            'target' => $target,
            'terisi' => $terisi
        ];
    }
}
