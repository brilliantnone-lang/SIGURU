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
    // ============================================================
    // INDEX
    // ============================================================
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnals = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'coverJurnal',
            'guruPengganti.user',
            'guruDigantikan.user',
        ])
            ->where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.jurnal-harian', compact('jurnals'));
    }

    // ============================================================
    // CREATE
    // ============================================================
    public function create(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $tanggalDipilih = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        $hariDariTanggal = strtolower(Carbon::parse($tanggalDipilih)->locale('id')->translatedFormat('l'));

        $jadwalHariItu = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariDariTanggal)
            ->orderBy('jam_mulai_ke')
            ->get();

        $jadwalTersedia = $jadwalHariItu->filter(function ($jadwal) use ($guru, $tanggalDipilih) {
            return !Journal::where('guru_id', $guru->id)
                ->where('jadwal_id', $jadwal->id)
                ->where('tanggal', $tanggalDipilih)
                ->exists();
        })->values();

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

    // ============================================================
    // STORE
    // ============================================================
    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'jadwal_id'           => 'required|exists:jadwal,id',
            'pokok_bahasan'       => 'nullable|string',
            'status_penyelesaian' => 'nullable|in:selesai,belum_selesai',
            'foto_kegiatan'       => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'guru_pendamping_id'  => 'nullable|exists:guru,id',
            'absensi'             => 'nullable|array',
            'absensi.*'           => 'in:hadir,sakit,izin,alpa',
            'status_mengajar'     => 'nullable|in:pengampu,pengganti',
            'jenis_penggantian'   => 'nullable|in:saya_digantikan,saya_menggantikan',
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

        $jadwal  = Jadwal::findOrFail($request->jadwal_id);
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        // Logika guru pengganti
        $guruId            = $guru->id;
        $guruPendampingId  = null;
        $guruPenggantiId   = null;
        $guruDigantikanId  = null;
        $jenisPengajar     = 'pengampu';
        $jenisPenggantian  = null;
        $statusPenggantian = 'tidak_ada';

        if ($request->status_mengajar === 'pengganti') {
            $jenisPengajar    = 'pengganti';
            $jenisPenggantian = $request->jenis_penggantian;

            if ($request->jenis_penggantian === 'saya_digantikan') {
                // Guru A buat jurnal, diisi nanti oleh Guru B
                $guruPenggantiId   = $request->guru_pendamping_id;
                $guruDigantikanId  = $guru->id;
                $statusPenggantian = 'menunggu_diisi';
            } elseif ($request->jenis_penggantian === 'saya_menggantikan') {
                // Guru B menggantikan Guru A, langsung isi
                $guruId            = $request->guru_pendamping_id;
                $guruPenggantiId   = $guru->id;
                $guruDigantikanId  = $request->guru_pendamping_id;
                $statusPenggantian = 'selesai_diisi';
            }
        }

        $fotoPath = null;
        if ($statusPenggantian !== 'menunggu_diisi' && $request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('foto-jurnal', 'public');
        }

        $pokokBahasan = $request->pokok_bahasan;
        if ($statusPenggantian === 'menunggu_diisi') {
            $pokokBahasan = '(Menunggu diisi oleh guru pengganti)';
        }

        $jurnal = Journal::create([
            'guru_id'             => $guruId,
            'guru_pendamping_id'  => $guruPendampingId,
            'guru_pengganti_id'   => $guruPenggantiId,
            'guru_digantikan_id'  => $guruDigantikanId,
            'jenis_pengajar'      => $jenisPengajar,
            'jenis_penggantian'   => $jenisPenggantian,
            'status_penggantian'  => $statusPenggantian,
            'cover_jurnal_id'     => $coverAktif->id,
            'kelas_id'            => $jadwal->kelas_id,
            'jadwal_id'           => $jadwal->id,
            'jam_mulai_ke'        => $jadwal->jam_mulai_ke,
            'jam_selesai_ke'      => $jadwal->jam_selesai_ke,
            'tanggal'             => $tanggal,
            'pokok_bahasan'       => $pokokBahasan,
            'status_penyelesaian' => $request->status_penyelesaian ?? 'belum_selesai',
            'alasan_belum_selesai' => $request->alasan_belum_selesai,
            'keterangan'          => $request->keterangan,
            'status_validasi'     => 'belum_valid',
            'foto_kegiatan'       => $fotoPath,
            'metode_absensi'      => $request->metode_absensi ?? 'otomatis',
        ]);

        if ($statusPenggantian !== 'menunggu_diisi' && $request->has('absensi')) {
            foreach ($request->absensi as $murid_id => $status) {
                Attendance::updateOrCreate(
                    ['journal_id' => $jurnal->id, 'murid_id' => $murid_id],
                    ['status_kehadiran' => $status]
                );
            }
        }

        return redirect()->route('guru.tambah-jurnal')
            ->with('jurnal_created', true);
    }

    // ============================================================
    // SHOW
    // ============================================================
    public function show($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'attendances.murid',
            'coverJurnal',
            'guruPendamping.user',
            'guruPengganti.user',
            'guruDigantikan.user',
        ])
            ->untukGuru($guru->id)
            ->findOrFail($id);

        $murids = Murid::where('kelas_id', $jurnal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get(['id', 'nama_siswa']);

        return view('guru.lihat-jurnal', compact('jurnal', 'murids'));
    }

    // ============================================================
    // EDIT
    // ============================================================
    public function edit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::with(['attendances'])
            ->untukGuru($guru->id)
            ->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        // Cek hak akses
        if ($jurnal->status_penggantian === 'menunggu_diisi') {
            if ($jurnal->guru_pengganti_id !== $guru->id) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Jurnal ini sedang menunggu diisi oleh guru pengganti.');
            }
        } else {
            $bolehAkses = ($jurnal->guru_id === $guru->id)
                || ($jurnal->guru_pengganti_id === $guru->id);

            if (! $bolehAkses) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Anda tidak berhak mengedit jurnal ini.');
            }
        }

        $jadwal = $jurnal->jadwal;
        $murids = Murid::where('kelas_id', $jurnal->kelas_id)
            ->orderBy('nama_siswa', 'asc')->get();
        $gurus = Guru::with('user')->where('id', '!=', $guru->id)->get();
        $coverAktif = CoverJurnal::find($jurnal->cover_jurnal_id);

        return view('guru.edit-jurnal', compact('jurnal', 'jadwal', 'murids', 'gurus', 'coverAktif'));
    }

    // ============================================================
    // UPDATE
    // ============================================================
    public function update(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::untukGuru($guru->id)->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah tervalidasi tidak bisa diedit.');
        }

        // Cek hak akses
        // Cek hak akses
        $guruPenggantiAktif = $jurnal->guru_pengganti_id
            ?? $jurnal->guru_digantikan_id;

        if (in_array($jurnal->status_penggantian, ['menunggu_diisi', 'belum_direvisi'])) {
            // Hanya guru pengganti yang bisa isi/revisi
            if ($guruPenggantiAktif !== $guru->id) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Jurnal ini sedang menunggu diisi/direvisi oleh guru pengganti.');
            }
        } else {
            $bolehAkses = ($jurnal->guru_id === $guru->id)
                || ($guruPenggantiAktif === $guru->id);

            if (! $bolehAkses) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Anda tidak berhak mengedit jurnal ini.');
            }
        }

        // Validasi — pokok_bahasan & status_penyelesaian nullable
        // (karena Siti yang edit jurnal penggantian tidak mengisi field ini)
        $request->validate([
            'pokok_bahasan'       => 'nullable|string',
            'status_penyelesaian' => 'nullable|in:selesai,belum_selesai',
            'foto_kegiatan'       => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'absensi'             => 'nullable|array',
            'absensi.*'           => 'in:hadir,sakit,izin,alpa',
            'guru_pendamping_id'  => 'nullable|exists:guru,id',
        ]);

        $data = [];

        // Field yang diisi Budi (pengganti) atau pemilik jurnal biasa
        if ($request->filled('pokok_bahasan')) {
            $data['pokok_bahasan'] = $request->pokok_bahasan;
        }
        if ($request->filled('status_penyelesaian')) {
            $data['status_penyelesaian'] = $request->status_penyelesaian;
        }
        if ($request->has('alasan_belum_selesai')) {
            $data['alasan_belum_selesai'] = $request->alasan_belum_selesai;
        }
        if ($request->has('keterangan')) {
            $data['keterangan'] = $request->keterangan;
        }

        // 🔧 Siti (pemilik) boleh ubah guru_pendamping_id di jurnal penggantian
        // 🔧 Siti (pemilik) boleh ubah guru_pendamping_id di jurnal penggantian
        if ($jurnal->status_penggantian !== 'tidak_ada' && $jurnal->guru_id === $guru->id) {
            if ($request->filled('guru_pendamping_id')) {
                $guruBaruId = $request->guru_pendamping_id;
                $guruLamaId = $jurnal->guru_pengganti_id ?? $jurnal->guru_digantikan_id;

                if ($guruBaruId != $guruLamaId) {
                    // Guru pengganti BERUBAH
                    if ($jurnal->jenis_penggantian === 'saya_digantikan') {
                        $data['guru_pengganti_id'] = $guruBaruId;
                    } elseif ($jurnal->jenis_penggantian === 'saya_menggantikan') {
                        $data['guru_digantikan_id'] = $guruBaruId;
                    }

                    // 🔧 Kalau sebelumnya sudah diisi → status jadi 'belum_direvisi'
                    if ($jurnal->status_penggantian === 'selesai_diisi') {
                        $data['status_penggantian'] = 'belum_direvisi';
                    }
                    // Kalau sebelumnya 'menunggu_diisi' → tetap 'menunggu_diisi'
                }
            }
        }

        // Tandai selesai kalau guru pengganti submit
        $guruPenggantiAktif = $jurnal->guru_pengganti_id
            ?? $jurnal->guru_digantikan_id; // untuk jenis 'saya_menggantikan'

        if (
            in_array($jurnal->status_penggantian, ['menunggu_diisi', 'belum_direvisi'])
            && $guru->id === $guruPenggantiAktif
        ) {
            $data['status_penggantian'] = 'selesai_diisi';
        }

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

        return redirect()
            ->route('guru.edit-jurnal', $jurnal->id)
            ->with('jurnal_updated', true);
    }

    // ============================================================
    // JURNAL PENGGANTIAN — Menu Guru B
    // ============================================================
    public function jurnalPenggantian()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnals = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'guruDigantikan.user',
        ])
            ->where('guru_pengganti_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.jurnal-penggantian', compact('jurnals'));
    }

    // ============================================================
    // GET MURID (AJAX)
    // ============================================================
    public function getMurid($jadwal_id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jadwal = Jadwal::where('guru_id', $guru->id)
            ->with(['kelas', 'mataPelajaran'])
            ->findOrFail($jadwal_id);

        $murids = Murid::where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama_siswa', 'asc')
            ->get(['id', 'nama_siswa']);

        $lastJurnal = Journal::where('kelas_id', $jadwal->kelas_id)
            ->where('guru_id', $guru->id)
            ->where('tanggal', Carbon::now()->format('Y-m-d'))
            ->whereHas('attendances')
            ->orderBy('id', 'desc')
            ->first();

        $lastAttendance = [];
        if ($lastJurnal) {
            $lastAttendance = $lastJurnal->attendances
                ->pluck('status_kehadiran', 'murid_id')
                ->toArray();
        }

        $result = $murids->map(function ($murid) use ($lastAttendance) {
            return [
                'id'              => $murid->id,
                'nama_siswa'      => $murid->nama_siswa,
                'status_terakhir' => $lastAttendance[$murid->id] ?? 'hadir',
            ];
        });

        return response()->json([
            'murids' => $result,
            'sesi' => [
                'mulai'   => $jadwal->jam_mulai_ke,
                'selesai' => $jadwal->jam_selesai_ke,
                'label'   => "Sesi {$jadwal->jam_mulai_ke}–{$jadwal->jam_selesai_ke}",
            ],
            'kelas' => $jadwal->kelas->nama_kelas ?? '-',
            'mapel' => $jadwal->mataPelajaran->nama_mata_pelajaran ?? '-',
            'ada_absensi_terakhir'     => $lastJurnal !== null,
            'tanggal_absensi_terakhir' => $lastJurnal?->tanggal,
        ]);
    }

    // ============================================================
    // CATATAN REVISI
    // ============================================================
    public function catatanRevisi($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $jurnal = Journal::with(['coverJurnal', 'kelas', 'jadwal.mataPelajaran'])
            ->untukGuru($guru->id)
            ->findOrFail($id);

        return view('guru.catatan-revisi', compact('jurnal'));
    }

    // ============================================================
    // AJUKAN ULANG
    // ============================================================
    public function ajukanUlang($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::untukGuru($guru->id)->findOrFail($id);

        if ($jurnal->status_validasi !== 'menunggu_revisi') {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Jurnal ini tidak dalam status menunggu revisi.');
        }

        Journal::where('cover_jurnal_id', $jurnal->cover_jurnal_id)
            ->untukGuru($guru->id)
            ->where('status_validasi', 'menunggu_revisi')
            ->update(['status_validasi' => 'sudah_revisi']);

        return redirect()
            ->back()
            ->with('jurnal_diajukan_ulang', true);
    }

    // ============================================================
    // EXPORT PDF
    // ============================================================
    public function exportPdf($cover_id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $cover = CoverJurnal::findOrFail($cover_id);

        $jurnals = Journal::with([
            'kelas',
            'jadwal.mataPelajaran',
            'attendances.murid',
        ])
            ->where('cover_jurnal_id', $cover_id)
            ->untukGuru($guru->id)
            ->where('status_validasi', 'valid')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai_ke', 'asc')
            ->get();

        if ($jurnals->isEmpty()) {
            return redirect()->route('guru.jurnal-harian')
                ->with('error', 'Belum ada jurnal tervalidasi untuk diekspor di semester ini.');
        }

        $namaGuru = $guru->user->name ?? $guru->nama_guru ?? 'Guru';
        $nipGuru  = $guru->nip_guru ?? '-';

        $logoSekolah = null;
        if ($cover->logo && Storage::disk('public')->exists($cover->logo)) {
            $logoPath = Storage::disk('public')->path($cover->logo);
            $logoMime = mime_content_type($logoPath);
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSekolah = "data:{$logoMime};base64,{$logoData}";
        }

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

    // ============================================================
    // DESTROY
    // ============================================================
    public function destroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $jurnal = Journal::untukGuru($guru->id)->findOrFail($id);

        if ($jurnal->status_validasi === 'valid') {
            return redirect()
                ->route('guru.jurnal-harian')
                ->with('error', 'Jurnal yang sudah divalidasi tidak dapat dihapus.');
        }

        if ($jurnal->status_penggantian === 'menunggu_diisi') {
            if ($jurnal->guru_pengganti_id !== $guru->id) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Jurnal ini sedang menunggu diisi oleh guru pengganti.');
            }
        } else {
            $bolehAkses = ($jurnal->guru_id === $guru->id)
                || ($jurnal->guru_pengganti_id === $guru->id);

            if (! $bolehAkses) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', 'Anda tidak berhak menghapus jurnal ini.');
            }
        }

        if ($jurnal->foto_kegiatan) {
            Storage::disk('public')->delete($jurnal->foto_kegiatan);
        }

        $jurnal->delete();

        return redirect()
            ->route('guru.jurnal-harian')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
