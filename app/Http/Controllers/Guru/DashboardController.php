<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Journal;
use App\Models\KalenderAkademik;
use App\Models\CoverJurnal;
use App\Models\EventSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        if (!$guru) return redirect('/')->with('error', 'Data guru tidak ditemukan.');

        $hariIni = Carbon::now();
        $tanggalHariIni = $hariIni->format('Y-m-d');
        $namaHari = strtolower($hariIni->locale('id')->translatedFormat('l'));

        // 1. Jadwal Hari Ini
        $jadwalHariIni = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $namaHari)
            ->orderBy('jam_mulai_ke')
            ->get();

        $jurnalHariIni = Journal::where('guru_id', $guru->id)
            ->where('tanggal', $tanggalHariIni)
            ->pluck('jadwal_id')
            ->toArray();

        // 2. HITUNG TARGET DINAMIS (Mulai Semester s/d HARI INI)
        $kalenderAktif = KalenderAkademik::getKalenderAktif();
        $totalTargetSampaiHariIni = 0;
        $totalJurnalSampaiHariIni = 0;
        $coverAktifId = null;

        if ($kalenderAktif) {
            $coverAktif = CoverJurnal::where('tahun_ajaran', $kalenderAktif->tahun_ajaran)
                ->where('semester', $kalenderAktif->semester)
                ->first();
            if ($coverAktif) {
                $coverAktifId = $coverAktif->id;

                $mulai = Carbon::parse($kalenderAktif->tanggal_mulai);
                // Ambil tanggal paling akhir antara hari ini dan tanggal selesai semester
                // Tapi kita hanya hitung sampai hari ini saja.
                $batasAkhir = $hariIni->copy();

                // Jika hari ini melebihi semester, pakai tanggal selesai semester
                if ($batasAkhir->gt(Carbon::parse($kalenderAktif->tanggal_selesai))) {
                    $batasAkhir = Carbon::parse($kalenderAktif->tanggal_selesai);
                }

                // Hitung total pertemuan dari mulai semester s/d hari ini
                $semuaJadwalGuru = Jadwal::where('guru_id', $guru->id)->get();

                foreach ($semuaJadwalGuru as $jadwal) {
                    $hariJadwal = $jadwal->hari;
                    $indexHari = [
                        'senin' => 1,
                        'selasa' => 2,
                        'rabu' => 3,
                        'kamis' => 4,
                        'jumat' => 5,
                        'sabtu' => 6
                    ][$hariJadwal] ?? 1;

                    $jumlahMinggu = 0;
                    $current = $mulai->copy();
                    while ($current->lte($batasAkhir)) {
                        if ($current->dayOfWeek === $indexHari) {
                            $jumlahMinggu++;
                        }
                        $current->addDay();
                    }
                    $totalTargetSampaiHariIni += $jumlahMinggu;
                }

                // Hitung jurnal yang SUDAH diisi dari awal semester s/d hari ini
                $totalJurnalSampaiHariIni = Journal::where('guru_id', $guru->id)
                    ->where('cover_jurnal_id', $coverAktifId)
                    ->where('tanggal', '<=', $tanggalHariIni)
                    ->count();
            }
        }

        // 3. Statistik
        $totalJadwalHariIni = $jadwalHariIni->count();
        $totalJurnalHariIni = count($jurnalHariIni);

        // 4. Pengingat — SEMUA jadwal terlewat dari awal semester s/d kemarin
        $pengingat = collect();

        if ($kalenderAktif) {
            $mulaiSemester = Carbon::parse($kalenderAktif->tanggal_mulai);
            $kemarin = $hariIni->copy()->subDay();
            $batasAkhir = $kemarin;

            if ($mulaiSemester->lte($batasAkhir)) {
                $semuaJadwalGuru = Jadwal::with(['kelas', 'mataPelajaran'])
                    ->where('guru_id', $guru->id)
                    ->get();

                foreach ($semuaJadwalGuru as $jadwal) {
                    $indexHari = [
                        'senin' => 1,
                        'selasa' => 2,
                        'rabu' => 3,
                        'kamis' => 4,
                        'jumat' => 5,
                        'sabtu' => 6,
                    ][strtolower($jadwal->hari)] ?? null;

                    if (!$indexHari) continue;

                    $current = $mulaiSemester->copy();
                    while ($current->lte($batasAkhir)) {
                        if ($current->dayOfWeek === $indexHari) {
                            $sudahIsi = Journal::where('guru_id', $guru->id)
                                ->where('jadwal_id', $jadwal->id)
                                ->where('tanggal', $current->format('Y-m-d'))
                                ->exists();

                            if (!$sudahIsi) {
                                $pengingat->push((object) [
                                    'jadwal_id' => $jadwal->id,
                                    'tanggal' => $current->format('Y-m-d'),
                                    'kelas' => $jadwal->kelas->nama_kelas ?? '-',
                                    'mapel' => $jadwal->mataPelajaran->nama_mata_pelajaran ?? '-',
                                    'jam_mulai_ke' => $jadwal->jam_mulai_ke,
                                    'jam_selesai_ke' => $jadwal->jam_selesai_ke,
                                ]);
                            }
                        }
                        $current->addDay();
                    }
                }

                $pengingat = $pengingat->sortBy('tanggal')->values();
            }
        }

        return view('guru.dashboard', compact(
            'guru',
            'jadwalHariIni',
            'jurnalHariIni',
            'totalJadwalHariIni',
            'totalJurnalHariIni',
            'totalJurnalSampaiHariIni',
            'totalTargetSampaiHariIni',
            'pengingat'
        ));
    }
}
