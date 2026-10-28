<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Attendance;
use App\Models\ModulAjar;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now()->format('Y-m-d');
        $namaHari = strtolower(Carbon::now()->translatedFormat('l')); // contoh: senin

        // 1. Statistik Utama
        $totalJurnal = Journal::count();
        $totalGuru = Guru::count();
        $totalMapel = MataPelajaran::count();
        $totalKelas = Kelas::count();
        $totalMurid = Murid::count();

        // 2. Rekap Absensi Hari Ini
        $absenHariIni = Attendance::join('journal', 'attendances.journal_id', '=', 'journal.id')
                                  ->where('journal.tanggal', $hariIni)
                                  ->select(
                                      DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "hadir" THEN 1 ELSE 0 END) as hadir'),
                                      DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "sakit" THEN 1 ELSE 0 END) as sakit'),
                                      DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "izin" THEN 1 ELSE 0 END) as izin'),
                                      DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "alpa" THEN 1 ELSE 0 END) as alpa')
                                  )->first();

        // 3. Pengingat Jurnal (Guru yang punya jadwal hari ini tapi belum isi jurnal)
        // Ambil guru yang punya jadwal hari ini
        $jadwalHariIni = Jadwal::with('guru.user')
                               ->where('hari', $namaHari)
                               ->get();
        
        $guruBelumIsi = collect();
        $guruIds = $jadwalHariIni->pluck('guru_id')->unique();

        foreach ($guruIds as $gId) {
            $sudahIsi = Journal::where('guru_id', $gId)->where('tanggal', $hariIni)->exists();
            if (!$sudahIsi) {
                $guru = $jadwalHariIni->where('guru_id', $gId)->first();
                if ($guru) $guruBelumIsi->push($guru->guru->user->name);
            }
        }

        // 4. Jurnal Terbaru (5 data terakhir)
        $jurnalTerbaru = Journal::with(['guru.user', 'kelas', 'jadwal.mataPelajaran'])
                                ->orderBy('tanggal', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        // 5. Bahan Ajar Terbaru (5 data terakhir)
        $bahanAjarTerbaru = ModulAjar::with(['guru.user', 'guru.mataPelajaran'])
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)
                                     ->get();

        return view('admin.dashboard', compact(
            'totalJurnal', 'totalGuru', 'totalMapel', 'totalKelas', 'totalMurid',
            'absenHariIni', 'guruBelumIsi', 'jurnalTerbaru', 'bahanAjarTerbaru'
        ));
    }
}