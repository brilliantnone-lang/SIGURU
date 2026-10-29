<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\MataPelajaran;
use App\Models\Jadwal;
use App\Models\Journal;
use App\Models\Attendance;
use App\Models\ModulAjar;
use App\Models\KalenderAkademik;
use App\Models\CoverJurnal;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Mapel
        $mapelMat = MataPelajaran::where('nama_mata_pelajaran', 'Matematika')->first();
        $mapelIPA = MataPelajaran::where('nama_mata_pelajaran', 'IPA')->first();
        
        // 2. Buat User Guru
        $userGuru1 = User::firstOrCreate(
            ['username' => 'siti'],
            ['name' => 'Siti Rahma, S.Pd.', 'password' => Hash::make('guru123'), 'role' => 'guru', 'jenis_kelamin' => 'Perempuan']
        );
        $guru1 = Guru::firstOrCreate(
            ['user_id' => $userGuru1->id],
            ['mata_pelajaran_id' => $mapelMat->id ?? 1, 'nip_guru' => '198001012005011002']
        );

        $userGuru2 = User::firstOrCreate(
            ['username' => 'budi'],
            ['name' => 'Budi Santoso, S.Pd.', 'password' => Hash::make('guru123'), 'role' => 'guru', 'jenis_kelamin' => 'Laki-laki']
        );
        $guru2 = Guru::firstOrCreate(
            ['user_id' => $userGuru2->id],
            ['mata_pelajaran_id' => $mapelIPA->id ?? 2, 'nip_guru' => '198001012005011003']
        );

        // 3. Ambil Kelas
        $kelas7A = Kelas::where('nama_kelas', 'VII A')->first() ?? Kelas::first();
        $kelas8B = Kelas::where('nama_kelas', 'VIII B')->first() ?? Kelas::skip(1)->first();

        // 4. Buat Jadwal
        $jadwal1 = Jadwal::firstOrCreate([
            'guru_id' => $guru1->id, 'kelas_id' => $kelas7A->id, 'mata_pelajaran_id' => $mapelMat->id ?? 1,
            'hari' => 'senin', 'jam_mulai_ke' => 1, 'jam_selesai_ke' => 2,
        ]);
        $jadwal2 = Jadwal::firstOrCreate([
            'guru_id' => $guru2->id, 'kelas_id' => $kelas8B->id, 'mata_pelajaran_id' => $mapelIPA->id ?? 2,
            'hari' => 'senin', 'jam_mulai_ke' => 3, 'jam_selesai_ke' => 4,
        ]);

        // 5. Buat Murid
        $murids7A = [];
        for ($i = 1; $i <= 5; $i++) {
            $murids7A[] = Murid::firstOrCreate(['nis' => '23001' . $i], ['kelas_id' => $kelas7A->id, 'nama_siswa' => 'Siswa 7A-' . $i, 'jenis_kelamin' => 'L']);
        }
        $murids8B = [];
        for ($i = 1; $i <= 5; $i++) {
            $murids8B[] = Murid::firstOrCreate(['nis' => '23002' . $i], ['kelas_id' => $kelas8B->id, 'nama_siswa' => 'Siswa 8B-' . $i, 'jenis_kelamin' => 'P']);
        }

        $admin = Admin::first();
        if (!$admin) return;

        // =========================================================
        // COVER 1: GENAP 2025/2026 (SUDAH SELESAI)
        // =========================================================
        $coverGenap = CoverJurnal::firstOrCreate(
            ['tahun_ajaran' => '2025/2026', 'semester' => 'Genap'],
            ['admin_id' => $admin->id, 'nama_sekolah' => 'SMP NEGERI 15 BANJARMASIN', 'nama_kepsek' => 'Kepala Sekolah', 'nip_kepsek' => '197501012000011001']
        );

        // Kalender Genap (Selesai)
        KalenderAkademik::firstOrCreate(
            ['tahun_ajaran' => '2025/2026', 'semester' => 'Genap'],
            ['admin_id' => $admin->id, 'tanggal_mulai' => Carbon::now()->subMonths(8)->format('Y-m-d'), 'tanggal_selesai' => Carbon::now()->subMonths(2)->format('Y-m-d'), 'nama_file' => 'Kalender_Genap.pdf', 'path_file' => 'dummy/kalender.pdf']
        );

        for ($i = 9; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subMonths(6)->subDays($i)->format('Y-m-d');
            $jurnalGenap1 = Journal::firstOrCreate(
                ['guru_id' => $guru1->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas7A->id, 'cover_jurnal_id' => $coverGenap->id],
                ['jadwal_id' => $jadwal1->id, 'jam_mulai_ke' => 1, 'jam_selesai_ke' => 2, 'pokok_bahasan' => 'Aljabar Genap', 'status_penyelesaian' => 'selesai', 'status_validasi' => 'valid', 'validator_id' => $admin->user_id, 'validated_at' => now()]
            );
            $this->buatAbsensi($jurnalGenap1->id, $murids7A);

            $jurnalGenap2 = Journal::firstOrCreate(
                ['guru_id' => $guru2->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas8B->id, 'cover_jurnal_id' => $coverGenap->id],
                ['jadwal_id' => $jadwal2->id, 'jam_mulai_ke' => 3, 'jam_selesai_ke' => 4, 'pokok_bahasan' => 'Pencernaan Genap', 'status_penyelesaian' => 'selesai', 'status_validasi' => 'valid', 'validator_id' => $admin->user_id, 'validated_at' => now()]
            );
            $this->buatAbsensi($jurnalGenap2->id, $murids8B);
        }

        // =========================================================
        // COVER 2: GANJIL 2026/2027 (SEDANG BERJALAN)
        // =========================================================
        $coverGanjil = CoverJurnal::firstOrCreate(
            ['tahun_ajaran' => '2026/2027', 'semester' => 'Ganjil'],
            ['admin_id' => $admin->id, 'nama_sekolah' => 'SMP NEGERI 15 BANJARMASIN', 'nama_kepsek' => 'Kepala Sekolah', 'nip_kepsek' => '197501012000011001']
        );

        // Kalender Ganjil (Berjalan)
        KalenderAkademik::firstOrCreate(
            ['tahun_ajaran' => '2026/2027', 'semester' => 'Ganjil'],
            ['admin_id' => $admin->id, 'tanggal_mulai' => Carbon::now()->subMonths(2)->format('Y-m-d'), 'tanggal_selesai' => Carbon::now()->addMonths(2)->format('Y-m-d'), 'nama_file' => 'Kalender_Ganjil.pdf', 'path_file' => 'dummy/kalender.pdf']
        );

        for ($i = 13; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i)->format('Y-m-d');
            $statusSiti = ($i >= 11) ? 'valid' : (($i >= 7) ? 'belum_valid' : 'menunggu_revisi');
            $catatanSiti = ($i < 7) ? 'Mohon lengkapi foto.' : null;
            $validator = ($statusSiti !== 'belum_valid') ? $admin->user_id : null;
            $validatedAt = ($statusSiti !== 'belum_valid') ? now() : null;

            $jurnal1 = Journal::firstOrCreate(
                ['guru_id' => $guru1->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas7A->id, 'cover_jurnal_id' => $coverGanjil->id],
                ['jadwal_id' => $jadwal1->id, 'jam_mulai_ke' => 1, 'jam_selesai_ke' => 2, 'pokok_bahasan' => 'Aljabar Ganjil', 'status_penyelesaian' => 'selesai', 'status_validasi' => $statusSiti, 'catatan_validasi' => $catatanSiti, 'validator_id' => $validator, 'validated_at' => $validatedAt]
            );
            $this->buatAbsensi($jurnal1->id, $murids7A);

            $jurnal2 = Journal::firstOrCreate(
                ['guru_id' => $guru2->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas8B->id, 'cover_jurnal_id' => $coverGanjil->id],
                ['jadwal_id' => $jadwal2->id, 'jam_mulai_ke' => 3, 'jam_selesai_ke' => 4, 'pokok_bahasan' => 'Pencernaan Ganjil', 'status_penyelesaian' => 'selesai', 'status_validasi' => 'valid', 'validator_id' => $admin->user_id, 'validated_at' => now()]
            );
            $this->buatAbsensi($jurnal2->id, $murids8B);
        }

        // 8. Bahan Ajar
        ModulAjar::firstOrCreate(['guru_id' => $guru1->id, 'nama_file' => 'Modul_Aljabar.pdf'], ['path_file' => 'dummy/modul_aljabar.pdf']);
        ModulAjar::firstOrCreate(['guru_id' => $guru2->id, 'nama_file' => 'Modul_Pencernaan.pdf'], ['path_file' => 'dummy/modul_pencernaan.pdf']);
    }

    private function buatAbsensi($journalId, $murids)
    {
        foreach ($murids as $index => $m) {
            $status = 'hadir';
            if ($index == 1) $status = 'sakit';
            if ($index == 2) $status = 'izin';
            Attendance::firstOrCreate(['journal_id' => $journalId, 'murid_id' => $m->id], ['status_kehadiran' => $status]);
        }
    }
}