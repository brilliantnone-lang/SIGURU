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

    public function create(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // 🔑 Tanggal dari query string, default hari ini
        $tanggalDipilih = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        $hariDariTanggal = strtolower(Carbon::parse($tanggalDipilih)->locale('id')->translatedFormat('l'));

        // Ambil jadwal guru pada hari dari tanggal yang dipilih
        $jadwalHariItu = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariDariTanggal)
            ->orderBy('jam_mulai_ke')
            ->get();

        // Filter jadwal yang belum ada jurnalnya di tanggal itu
        $jadwalTersedia = $jadwalHariItu->filter(function ($jadwal) use ($guru, $tanggalDipilih) {
            return !Journal::where('guru_id', $guru->id)
                ->where('jadwal_id', $jadwal->id)
                ->where('tanggal', $tanggalDipilih)
                ->exists();
        })->values();

        // 🔑 Jadwal yang dipilih dari dashboard
        $jadwalDipilih = null;
        if ($request->filled('jadwal_id')) {
            $jadwalDipilih = $jadwalTersedia->firstWhere('id', $request->jadwal_id);
        }

        $kalenderAktif = KalenderAkademik::getKalenderAktif();
        $coverAktif = null;
        if ($kalenderAktif) {
            $coverAktif = CoverJurnal::where('tahun_ajaran', $kalenderAktif->tahun_ajaran)
                ->where('semester', $kalenderAktif->semester)
                ->first();
        }

        $gurus = Guru::with('user')->where('id', '!=', $guru->id)->get();

        return view('guru.tambah-jurnal', compact(
            'jadwalTersedia',
            'coverAktif',
            'gurus',
            'jadwalDipilih',
            'tanggalDipilih'
        ));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'pokok_bahasan' => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,belum_selesai',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'guru_pendamping_id' => 'nullable|exists:guru,id',
            'absensi' => 'nullable|array',
            'absensi.*' => 'in:hadir,sakit,izin,alpa',
            'status_mengajar' => 'nullable|in:pengampu,pengganti',
            'jenis_penggantian' => 'nullable|in:saya_digantikan,saya_menggantikan',
        ]);

        $kalenderAktif = KalenderAkademik::getKalenderAktif();
        if (!$kalenderAktif) {
            return redirect()->back()->withInput()->with('error', 'Belum ada Kalender Akademik aktif.');
        }

        $coverAktif = CoverJurnal::where('tahun_ajaran', $kalenderAktif->tahun_ajaran)
            ->where('semester', $kalenderAktif->semester)
            ->first();
        if (!$coverAktif) {
            return redirect()->back()->withInput()->with('error', 'Belum ada Cover Jurnal aktif.');
        }

        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $tanggal = $request->filled('tanggal') ? Carbon::parse($request->tanggal)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        // Logika Guru Pengganti
        $guruId = $guru->id;
        $guruPendampingId = null;

        if ($request->status_mengajar === 'pengganti') {
            if ($request->jenis_penggantian === 'saya_digantikan') {
                // Saya (guru login) digantikan oleh guru_pendamping_id
                $guruPendampingId = $request->guru_pendamping_id;
            } elseif ($request->jenis_penggantian === 'saya_menggantikan') {
                // Saya (guru login) menggantikan guru_pendamping_id (guru asli)
                $guruId = $request->guru_pendamping_id;
                $guruPendampingId = $guru->id;
            }
        }

        $fotoPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('foto-jurnal', 'public');
        }

        $jurnal = Journal::create([
            'guru_id' => $guruId,
            'guru_pendamping_id' => $guruPendampingId,
            'cover_jurnal_id' => $coverAktif->id,
            'kelas_id' => $jadwal->kelas_id,
            'jadwal_id' => $jadwal->id,
            'jam_mulai_ke' => $jadwal->jam_mulai_ke,
            'jam_selesai_ke' => $jadwal->jam_selesai_ke,
            'tanggal' => $tanggal,
            'pokok_bahasan' => $request->pokok_bahasan,
            'status_penyelesaian' => $request->status_penyelesaian,
            'alasan_belum_selesai' => $request->alasan_belum_selesai,
            'keterangan' => $request->keterangan,
            'status_validasi' => 'belum_valid',
            'foto_kegiatan' => $fotoPath,
        ]);

        // Simpan absensi
        if ($request->has('absensi')) {
            foreach ($request->absensi as $murid_id => $status) {
                Attendance::updateOrCreate(
                    ['journal_id' => $jurnal->id, 'murid_id' => $murid_id],
                    ['status_kehadiran' => $status]
                );
            }
        }

        return redirect()->route('guru.jurnal-harian')->with('success', 'Jurnal berhasil disimpan!');
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
            ->where(function ($q) use ($guru) {
                $q->where('guru_id', $guru->id)
                    ->orWhere('guru_pendamping_id', $guru->id);
            })
            ->findOrFail($id);

        $murids = Murid::where('kelas_id', $jurnal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get(['id', 'nama_siswa']);

        return view('guru.lihat-jurnal', compact('jurnal', 'murids'));
    }

    public function edit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::with(['attendances'])  // ← perlu attendances
            ->where(function ($q) use ($guru) {
                $q->where('guru_id', $guru->id)
                    ->orWhere('guru_pendamping_id', $guru->id);
            })
            ->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        $jadwal = $jurnal->jadwal;
        $murids = Murid::where('kelas_id', $jurnal->kelas_id)
            ->orderBy('nama_siswa', 'asc')->get();
        $gurus = Guru::with('user')->where('id', '!=', $guru->id)->get();
        $coverAktif = CoverJurnal::find($jurnal->cover_jurnal_id);

        return view('guru.edit-jurnal', compact('jurnal', 'jadwal', 'murids', 'gurus', 'coverAktif'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::where('guru_id', $guru->id)->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        $request->validate([
            'pokok_bahasan' => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,belum_selesai',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'guru_pendamping_id' => 'nullable|exists:guru,id',
            'absensi' => 'nullable|array',
            'absensi.*' => 'in:hadir,sakit,izin,alpa',
        ]);

        $data = [
            'pokok_bahasan' => $request->pokok_bahasan,
            'status_penyelesaian' => $request->status_penyelesaian,
            'alasan_belum_selesai' => $request->alasan_belum_selesai,
            'keterangan' => $request->keterangan,
            'guru_pendamping_id' => $request->guru_pendamping_id,
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

        return redirect()->route('guru.jurnal-harian')->with('success', 'Jurnal berhasil diperbarui!');
    }

    public function getMurid($jadwal_id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jadwal = Jadwal::where('guru_id', $guru->id)
            ->with(['kelas', 'mataPelajaran'])
            ->findOrFail($jadwal_id);

        $murids = Murid::where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get(['id', 'nama_siswa']);

        // 🔑 Ambil absensi terakhir di kelas yang sama (milik guru login)
        $lastJurnal = Journal::where('kelas_id', $jadwal->kelas_id)
            ->where('guru_id', $guru->id)
            ->where('tanggal', Carbon::now()->format('Y-m-d'))   // 🔑 HANYA HARI INI
            ->whereHas('attendances')
            ->orderBy('id', 'desc')
            ->first();

        $lastAttendance = [];
        if ($lastJurnal) {
            $lastAttendance = $lastJurnal->attendances
                ->pluck('status_kehadiran', 'murid_id')
                ->toArray();
        }

        // Gabungkan: setiap murid dapat field "status_terakhir"
        $result = $murids->map(function ($murid) use ($lastAttendance) {
            return [
                'id' => $murid->id,
                'nama_siswa' => $murid->nama_siswa,
                'status_terakhir' => $lastAttendance[$murid->id] ?? 'hadir',
            ];
        });

        // 🔑 Info sesi dari jam pelajaran
        return response()->json([
            'murids' => $result,
            'sesi' => [
                'mulai' => $jadwal->jam_mulai_ke,
                'selesai' => $jadwal->jam_selesai_ke,
                'label' => "Sesi {$jadwal->jam_mulai_ke}–{$jadwal->jam_selesai_ke}",
            ],
            'kelas' => $jadwal->kelas->nama_kelas ?? '-',
            'mapel' => $jadwal->mataPelajaran->nama_mata_pelajaran ?? '-',
            'ada_absensi_terakhir' => $lastJurnal !== null,
            'tanggal_absensi_terakhir' => $lastJurnal?->tanggal,
        ]);
    }

    public function catatanRevisi($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::with(['coverJurnal', 'kelas', 'jadwal.mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->findOrFail($id);

        return view('guru.catatan-revisi', compact('jurnal'));
    }

    public function ajukanUlang($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::where(function ($q) use ($guru) {
            $q->where('guru_id', $guru->id)
                ->orWhere('guru_pendamping_id', $guru->id);
        })
            ->findOrFail($id);

        if ($jurnal->status_validasi !== 'menunggu_revisi') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal ini tidak dalam status menunggu revisi.');
        }

        // 🔑 UPDATE SEMUA jurnal menunggu_revisi dalam cover yang sama
        $jumlah = Journal::where('cover_jurnal_id', $jurnal->cover_jurnal_id)
            ->where(function ($q) use ($guru) {
                $q->where('guru_id', $guru->id)
                    ->orWhere('guru_pendamping_id', $guru->id);
            })
            ->where('status_validasi', 'menunggu_revisi')
            ->update(['status_validasi' => 'sudah_revisi']);

        return redirect()->route('guru.jurnal-harian')
            ->with('success', "{$jumlah} jurnal berhasil diajukan ulang. Menunggu validasi Kepala Sekolah.");
    }

    public function exportPdf($cover_id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $cover = CoverJurnal::findOrFail($cover_id);

        // Ambil semua jurnal VALID milik guru di cover ini
        $jurnals = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'attendances.murid',
        ])
            ->where('cover_jurnal_id', $cover_id)
            ->where(function ($q) use ($guru) {
                $q->where('guru_id', $guru->id)
                    ->orWhere('guru_pendamping_id', $guru->id);
            })
            ->where('status_validasi', 'valid')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai_ke', 'asc')
            ->get();

        if ($jurnals->isEmpty()) {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Belum ada jurnal tervalidasi untuk diekspor di semester ini.');
        }

        // Data untuk kop
        $namaGuru = $guru->user->name ?? $guru->nama_guru ?? 'Guru';
        $nipGuru = $guru->nip_guru ?? '-';

        // Logo sekolah (base64)
        $logoSekolah = null;
        if ($cover->logo && Storage::disk('public')->exists($cover->logo)) {
            $logoPath = Storage::disk('public')->path($cover->logo);
            $logoMime = mime_content_type($logoPath);
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSekolah = "data:{$logoMime};base64,{$logoData}";
        }

        // TTD Kepsek (base64) — dari user kepsek
        $ttdKepsek = null;
        $kepsekUser = \App\Models\User::where('role', 'kepsek')->whereNotNull('ttd_kepsek')->first();
        if ($kepsekUser && $kepsekUser->ttd_kepsek) {
            $ttdPath = storage_path('app/public/' . $kepsekUser->ttd_kepsek);
            if (file_exists($ttdPath)) {
                $ttdMime = mime_content_type($ttdPath);
                $ttdData = base64_encode(file_get_contents($ttdPath));
                $ttdKepsek = "data:{$ttdMime};base64,{$ttdData}";
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'guru.pdf.jurnal',
            compact('jurnals', 'cover', 'namaGuru', 'nipGuru', 'logoSekolah', 'ttdKepsek')
        )->setPaper('A4', 'portrait');

        $namaFile = 'Jurnal-' . $namaGuru . '-' . $cover->semester . '-' . str_replace('/', '-', $cover->tahun_ajaran) . '.pdf';

        return $pdf->download($namaFile);
    }
}