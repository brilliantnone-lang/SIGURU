<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\EventSekolah;
use App\Models\Murid;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        if (!$guru) return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');

        $hariIni = Carbon::now();
        $namaHari = strtolower($hariIni->locale('id')->translatedFormat('l'));
        $tanggal = $hariIni->format('Y-m-d');

        // 1. Ambil semua jadwal guru hari ini
        $jadwalHariIni = Jadwal::with(['kelas', 'mataPelajaran'])
                               ->where('guru_id', $guru->id)
                               ->where('hari', $namaHari)
                               ->orderBy('jam_mulai_ke')
                               ->get();

        if ($jadwalHariIni->isEmpty()) {
            return view('guru.presensi-siswa', [
                'message' => 'Anda tidak memiliki jadwal mengajar hari ini.',
                'jadwal' => null,
                'murids' => [],
                'isSesiPertama' => false,
            ]);
        }

        // 2. Ambil event sekolah hari ini (untuk cek jam berapa event berakhir)
        $eventsHariIni = EventSekolah::where('tanggal_mulai', '<=', $tanggal)
                                     ->where(function($q) use ($tanggal) {
                                         $q->where('tanggal_selesai', '>=', $tanggal)
                                           ->orWhereNull('tanggal_selesai');
                                     })
                                     ->where('is_full_day', false)
                                     ->get();

        // Kumpulkan jam yang terpakai event
        $jamEvent = [];
        foreach ($eventsHariIni as $ev) {
            if ($ev->jam_mulai_ke && $ev->jam_selesai_ke) {
                for ($i = $ev->jam_mulai_ke; $i <= $ev->jam_selesai_ke; $i++) {
                    $jamEvent[] = $i;
                }
            }
        }

        // 3. Tentukan jadwal mana yang merupakan "Sesi Pertama" (jam efektif terkecil yang bukan event)
        $jadwalSesiPertama = null;
        foreach ($jadwalHariIni as $j) {
            if (!in_array($j->jam_mulai_ke, $jamEvent)) {
                $jadwalSesiPertama = $j;
                break;
            }
        }

        if (!$jadwalSesiPertama) {
            return view('guru.presensi-siswa', [
                'message' => 'Semua jam mengajar Anda hari ini terhalang event sekolah.',
                'jadwal' => null,
                'murids' => [],
                'isSesiPertama' => false,
            ]);
        }

        // 4. Apakah jadwal ini milik guru yang login? (Sudah pasti, karena filter di awal)
        // 5. Cek apakah guru ini berhak mengisi absensi untuk jadwal ini
        //    Syarat: Ini adalah jadwal efektif pertama di kelas tersebut.
        //    (Kita asumsikan jadwalSesiPertama sudah benar karena urutan jam)
        
        // Tapi kita perlu memastikan jadwal ini bukan event dan guru ini yang mengajar.
        // Untuk simplifikasi, kita pakai jadwalSesiPertama.

        $murids = Murid::where('kelas_id', $jadwalSesiPertama->kelas_id)
                       ->orderBy('nama_siswa', 'asc')
                       ->get();

        // Cek apakah jurnal untuk jadwal ini hari ini sudah ada
        $jurnal = Journal::where('guru_id', $guru->id)
                         ->where('jadwal_id', $jadwalSesiPertama->id)
                         ->where('tanggal', $tanggal)
                         ->first();

        return view('guru.presensi-siswa', [
            'message' => null,
            'jadwal' => $jadwalSesiPertama,
            'murids' => $murids,
            'jurnal' => $jurnal,
            'isSesiPertama' => true,
            'tanggal' => $tanggal,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:hadir,sakit,izin,alpa',
        ]);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $tanggal = Carbon::now()->format('Y-m-d');

        // Buat atau cari jurnal untuk jadwal ini
        $jurnal = Journal::firstOrCreate(
            [
                'guru_id' => $guru->id,
                'jadwal_id' => $jadwal->id,
                'tanggal' => $tanggal,
            ],
            [
                'kelas_id' => $jadwal->kelas_id,
                'jam_mulai_ke' => $jadwal->jam_mulai_ke,
                'jam_selesai_ke' => $jadwal->jam_selesai_ke,
                'pokok_bahasan' => 'Absensi Sesi Pertama',
                'status_penyelesaian' => 'selesai',
                'status_validasi' => 'belum_valid',
            ]
        );

        // Simpan Absensi
        foreach ($request->absensi as $murid_id => $status) {
            Attendance::updateOrCreate(
                ['journal_id' => $jurnal->id, 'murid_id' => $murid_id],
                ['status_kehadiran' => $status]
            );
        }

        return redirect()->route('guru.presensi-siswa')->with('success', 'Absensi berhasil disimpan!');
    }
}