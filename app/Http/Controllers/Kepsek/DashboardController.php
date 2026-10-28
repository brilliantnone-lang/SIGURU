<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\ModulAjar;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now()->format('Y-m-d');

        // 1. Statistik
        $totalJurnal = Journal::count();
        $totalBahanAjar = ModulAjar::count();
        $jurnalHariIni = Journal::where('tanggal', $hariIni)->count();
        $belumDivalidasi = Journal::where('status_validasi', 'belum_valid')->count();

        // 2. Ambil 10 Jurnal Terbaru
        $jurnals = Journal::with(['guru.user', 'kelas', 'jadwal.mataPelajaran'])
                          ->orderBy('tanggal', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->take(10)
                          ->get();

        // 3. Data Grafik Absensi (4 Minggu Terakhir)
        $chartData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            $absen = Attendance::join('journal', 'attendances.journal_id', '=', 'journal.id')
                               ->whereBetween('journal.tanggal', [$startOfWeek, $endOfWeek])
                               ->select(
                                   DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "hadir" THEN 1 ELSE 0 END) as hadir'),
                                   DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "sakit" THEN 1 ELSE 0 END) as sakit'),
                                   DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "izin" THEN 1 ELSE 0 END) as izin'),
                                   DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "alpa" THEN 1 ELSE 0 END) as alpa')
                               )->first();

            $chartData[] = [
                'label' => 'Minggu ' . (4 - $i),
                'hadir' => (int) ($absen->hadir ?? 0),
                'sakit' => (int) ($absen->sakit ?? 0),
                'izin' => (int) ($absen->izin ?? 0),
                'alpa' => (int) ($absen->alpa ?? 0),
            ];
        }

        // Cari nilai maksimal dari total keseluruhan (Hadir+Sakit+Izin+Alpa) di tiap minggu
        $maxVal = 1;
        foreach ($chartData as $c) {
            $totalMingguIni = $c['hadir'] + $c['sakit'] + $c['izin'] + $c['alpa'];
            if ($totalMingguIni > $maxVal) {
                $maxVal = $totalMingguIni;
            }
        }

        return view('kepsek.dashboard', compact(
            'totalJurnal', 'totalBahanAjar', 'jurnalHariIni', 'belumDivalidasi', 
            'jurnals', 'chartData', 'maxVal'
        ));
    }
}