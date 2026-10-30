<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\CoverJurnal;
use App\Models\KalenderAkademik;
use App\Models\Murid;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnals = Journal::with(['kelas', 'jadwal.mataPelajaran', 'coverJurnal'])
            ->where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('guru.jurnal-harian', compact('jurnals'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $hariIni = Carbon::now();
        $namaHari = strtolower($hariIni->locale('id')->translatedFormat('l'));

        $jadwalHariIni = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $namaHari)
            ->get();

        $jadwalTersedia = $jadwalHariIni->filter(function ($j) use ($guru, $hariIni) {
            return !Journal::where('guru_id', $guru->id)
                ->where('jadwal_id', $j->id)
                ->where('tanggal', $hariIni->format('Y-m-d'))
                ->exists();
        });

        $kalenderAktif = KalenderAkademik::getKalenderAktif();
        $coverAktif = null;
        if ($kalenderAktif) {
            $coverAktif = CoverJurnal::where('tahun_ajaran', $kalenderAktif->tahun_ajaran)
                ->where('semester', $kalenderAktif->semester)
                ->first();
        }

        $gurus = Guru::with('user')->where('id', '!=', $guru->id)->get();

        return view('guru.tambah-jurnal', compact('jadwalTersedia', 'coverAktif', 'gurus'));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'jadwal_id'           => 'required|exists:jadwal,id',
            'pokok_bahasan'       => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,belum_selesai',
            'foto_kegiatan'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guru_pendamping_id'  => 'nullable|exists:guru,id',
            'absensi'             => 'nullable|array',
            'absensi.*'           => 'in:hadir,sakit,izin,alpa',
        ]);

        // 1. AMBIL COVER DARI KALENDER AKTIF (BUKAN DARI FORM)
        $kalenderAktif = KalenderAkademik::getKalenderAktif();
        if (!$kalenderAktif) {
            return redirect()->back()->with('error', 'Belum ada Kalender Akademik aktif untuk semester ini.');
        }

        $coverAktif = CoverJurnal::where('tahun_ajaran', $kalenderAktif->tahun_ajaran)
            ->where('semester', $kalenderAktif->semester)
            ->first();

        if (!$coverAktif) {
            return redirect()->back()->with('error', 'Belum ada Cover Jurnal untuk semester ' . $kalenderAktif->semester . ' ' . $kalenderAktif->tahun_ajaran . '.');
        }

        // 2. PROSES SIMPAN
        $jadwal  = Jadwal::findOrFail($request->jadwal_id);
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        $fotoPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('foto-jurnal', 'public');
        }

        $jurnal = Journal::create([
            'guru_id'              => $guru->id,
            'guru_pendamping_id'   => $request->guru_pendamping_id,
            'cover_jurnal_id'      => $coverAktif->id, // <-- AMAN, DARI SISTEM
            'kelas_id'             => $jadwal->kelas_id,
            'jadwal_id'            => $jadwal->id,
            'jam_mulai_ke'         => $jadwal->jam_mulai_ke,
            'jam_selesai_ke'       => $jadwal->jam_selesai_ke,
            'tanggal'              => $tanggal,
            'pokok_bahasan'        => $request->pokok_bahasan,
            'status_penyelesaian'  => $request->status_penyelesaian,
            'alasan_belum_selesai' => $request->alasan_belum_selesai,
            'keterangan'           => $request->keterangan,
            'status_validasi'      => 'belum_valid',
            'foto_kegiatan'        => $fotoPath,
        ]);

        if ($request->has('absensi')) {
            foreach ($request->absensi as $murid_id => $status) {
                Attendance::updateOrCreate(
                    ['journal_id' => $jurnal->id, 'murid_id' => $murid_id],
                    ['status_kehadiran' => $status]
                );
            }
        }

        return redirect()->route('guru.jurnal-harian')
            ->with('success', 'Jurnal berhasil disimpan!');
    }

    public function show($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'attendances.murid',
            'coverJurnal',
            'guruPendamping.user'
        ])
            ->where('guru_id', $guru->id)
            ->findOrFail($id);
        return view('guru.lihat-jurnal', compact('jurnal'));
    }

    public function edit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::with(['attendances'])
            ->where('guru_id', $guru->id)
            ->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        $jadwal     = $jurnal->jadwal;
        $murids     = Murid::where('kelas_id', $jurnal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get();
        $gurus      = Guru::with('user')->where('id', '!=', $guru->id)->get();
        $coverAktif = CoverJurnal::find($jurnal->cover_jurnal_id);

        return view('guru.edit-jurnal', compact('jurnal', 'jadwal', 'murids', 'gurus', 'coverAktif'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::where('guru_id', $guru->id)->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        $request->validate([
            'pokok_bahasan'       => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,belum_selesai',
            'foto_kegiatan'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guru_pendamping_id'  => 'nullable|exists:guru,id',
            'absensi'             => 'nullable|array',
            'absensi.*'           => 'in:hadir,sakit,izin,alpa',
        ]);

        $data = [
            'pokok_bahasan'        => $request->pokok_bahasan,
            'status_penyelesaian'  => $request->status_penyelesaian,
            'alasan_belum_selesai' => $request->alasan_belum_selesai,
            'keterangan'           => $request->keterangan,
            'guru_pendamping_id'   => $request->guru_pendamping_id,
        ];

        if ($jurnal->status_validasi === 'menunggu_revisi') {
            $data['status_validasi'] = 'sudah_revisi';
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($jurnal->foto_kegiatan && Storage::disk('public')->exists($jurnal->foto_kegiatan)) {
                Storage::disk('public')->delete($jurnal->foto_kegiatan);
            }
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('foto-jurnal', 'public');
        }

        $jurnal->update($data);

        if ($request->has('absensi')) {
            foreach ($request->absensi as $murid_id => $status) {
                Attendance::updateOrCreate(
                    ['journal_id' => $jurnal->id, 'murid_id' => $murid_id],
                    ['status_kehadiran' => $status]
                );
            }
        }

        return redirect()->route('guru.jurnal-harian')
            ->with('success', 'Jurnal berhasil diperbarui!');
    }

    /**
     * AJAX: daftar murid berdasarkan jadwal (dibatasi ke jadwal milik guru ybs)
     */
    public function getMurid($jadwal_id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jadwal = Jadwal::where('guru_id', $guru->id)->findOrFail($jadwal_id);

        $murids = Murid::where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get(['id', 'nama_siswa']);

        return response()->json($murids);
    }
}
