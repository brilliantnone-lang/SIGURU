<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kelasId = $request->input('kelas_id');
        $status = $request->input('status');

        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        
        // LOGIKA MODE
        // Mode detail_siswa jika: (Tanggal + Kelas) ATAU (Kelas + Status)
        $mode = 'rekap';
        if (($tanggal && $kelasId) || ($kelasId && $status)) {
            $mode = 'detail_siswa'; 
        }

        $data = [];
        $statusMap = []; 
        $namaKelas = '';

        if ($mode === 'detail_siswa') {
            // 1. Ambil data siswa di kelas tersebut
            $murids = Murid::where('kelas_id', $kelasId)->orderBy('nama_siswa', 'asc')->get();
            
            // 2. Ambil status kehadiran mereka
            foreach ($murids as $m) {
                $attQuery = Attendance::join('journal', 'attendances.journal_id', '=', 'journal.id')
                                      ->where('attendances.murid_id', $m->id);

                if ($tanggal) {
                    $attQuery->where('journal.tanggal', $tanggal);
                }
                if ($status) {
                    $attQuery->where('attendances.status_kehadiran', $status);
                }

                // Ambil data presensi terbaru
                $attendance = $attQuery->orderBy('journal.tanggal', 'desc')->first();
                
                // Jika data presensi ditemukan, simpan ke map
                if ($attendance) {
                    $statusMap[$m->id] = [
                        'status' => $attendance->status_kehadiran,
                        'tanggal' => $attendance->tanggal
                    ];
                }
            }

            // 3. Saring siswa: Hanya tampilkan yang punya data di statusMap
            $data = $murids->filter(function($m) use ($statusMap) {
                return isset($statusMap[$m->id]);
            });

            $namaKelas = Kelas::find($kelasId)->nama_kelas ?? '';

        } else {
            // Mode Rekap (Dikelompokkan)
            $query = Attendance::join('murid', 'attendances.murid_id', '=', 'murid.id')
                               ->join('kelas', 'murid.kelas_id', '=', 'kelas.id')
                               ->join('journal', 'attendances.journal_id', '=', 'journal.id');

            if ($tanggal) $query->where('journal.tanggal', $tanggal);
            if ($kelasId) $query->where('kelas.id', $kelasId);
            if ($status) $query->where('attendances.status_kehadiran', $status);

            if (!$tanggal && $kelasId) {
                // Kelas saja -> Group by Tanggal
                $data = $query->select(
                    'journal.tanggal',
                    DB::raw('COUNT(DISTINCT murid.id) as total'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "hadir" THEN 1 ELSE 0 END) as hadir'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "izin" THEN 1 ELSE 0 END) as izin'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "sakit" THEN 1 ELSE 0 END) as sakit'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "alpa" THEN 1 ELSE 0 END) as alpa')
                )->groupBy('journal.tanggal')->orderBy('journal.tanggal', 'desc')->get();

            } else {
                // Default / Tanggal saja / Status saja -> Group by Kelas & Tanggal
                $data = $query->select(
                    'kelas.id as kelas_id',
                    'kelas.nama_kelas',
                    'journal.tanggal',
                    DB::raw('COUNT(DISTINCT murid.id) as total'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "hadir" THEN 1 ELSE 0 END) as hadir'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "izin" THEN 1 ELSE 0 END) as izin'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "sakit" THEN 1 ELSE 0 END) as sakit'),
                    DB::raw('SUM(CASE WHEN attendances.status_kehadiran = "alpa" THEN 1 ELSE 0 END) as alpa')
                )->groupBy('kelas.id', 'kelas.nama_kelas', 'journal.tanggal')
                 ->orderBy('journal.tanggal', 'desc')
                 ->orderBy('kelas.nama_kelas', 'asc')->get();
            }
        }

        return view('admin.absensi', compact('data', 'kelas', 'tanggal', 'kelasId', 'status', 'mode', 'statusMap', 'namaKelas'));
    }
}