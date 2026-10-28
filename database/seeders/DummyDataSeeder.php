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
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Mapel
        $mapelMat = MataPelajaran::where('nama_mata_pelajaran', 'Matematika')->first();
        $mapelIPA = MataPelajaran::where('nama_mata_pelajaran', 'IPA')->first();
        
        // 2. Buat User Guru Tambahan
        $userGuru1 = User::firstOrCreate(
            ['username' => 'siti'],
            [
                'name' => 'Siti Rahma, S.Pd.', 
                'password' => Hash::make('guru123'), 
                'role' => 'guru', 
                'jenis_kelamin' => 'Perempuan' // Diperbaiki
            ]
        );
        $guru1 = Guru::firstOrCreate(
            ['user_id' => $userGuru1->id],
            ['mata_pelajaran_id' => $mapelMat->id ?? 1, 'nip_guru' => '198001012005011002']
        );

        $userGuru2 = User::firstOrCreate(
            ['username' => 'budi'],
            [
                'name' => 'Budi Santoso, S.Pd.', 
                'password' => Hash::make('guru123'), 
                'role' => 'guru', 
                'jenis_kelamin' => 'Laki-laki' // Diperbaiki
            ]
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
            'guru_id' => $guru1->id,
            'kelas_id' => $kelas7A->id,
            'mata_pelajaran_id' => $mapelMat->id ?? 1,
            'hari' => 'senin',
            'jam_mulai_ke' => 1,
            'jam_selesai_ke' => 2,
        ]);

        $jadwal2 = Jadwal::firstOrCreate([
            'guru_id' => $guru2->id,
            'kelas_id' => $kelas8B->id,
            'mata_pelajaran_id' => $mapelIPA->id ?? 2,
            'hari' => 'senin',
            'jam_mulai_ke' => 3,
            'jam_selesai_ke' => 4,
        ]);

        // 5. Buat Murid Dummy
        $murids7A = [];
        for ($i = 1; $i <= 5; $i++) {
            $murids7A[] = Murid::firstOrCreate(
                ['nis' => '23001' . $i],
                ['kelas_id' => $kelas7A->id, 'nama_siswa' => 'Siswa 7A-' . $i, 'jenis_kelamin' => 'L']
            );
        }
        $murids8B = [];
        for ($i = 1; $i <= 5; $i++) {
            $murids8B[] = Murid::firstOrCreate(
                ['nis' => '23002' . $i],
                ['kelas_id' => $kelas8B->id, 'nama_siswa' => 'Siswa 8B-' . $i, 'jenis_kelamin' => 'P']
            );
        }

        // 6. Buat Jurnal & Absensi (Mundur 7 hari)
        $admin = Admin::first();
        
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i)->format('Y-m-d');
            
            // Jurnal Guru 1 (Matematika)
            $jurnal1 = Journal::firstOrCreate(
                ['guru_id' => $guru1->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas7A->id],
                [
                    'jadwal_id' => $jadwal1->id,
                    'jam_mulai_ke' => 1,
                    'jam_selesai_ke' => 2,
                    'pokok_bahasan' => 'Materi Aljabar Dasar',
                    'status_penyelesaian' => 'selesai',
                    'status_validasi' => $i > 2 ? 'valid' : 'belum_valid',
                    'validator_id' => $i > 2 ? $admin->user_id : null,
                    'validated_at' => $i > 2 ? now() : null,
                ]
            );
            $this->buatAbsensi($jurnal1->id, $murids7A);

            // Jurnal Guru 2 (IPA)
            $jurnal2 = Journal::firstOrCreate(
                ['guru_id' => $guru2->id, 'tanggal' => $tanggal, 'kelas_id' => $kelas8B->id],
                [
                    'jadwal_id' => $jadwal2->id,
                    'jam_mulai_ke' => 3,
                    'jam_selesai_ke' => 4,
                    'pokok_bahasan' => 'Sistem Pencernaan Manusia',
                    'status_penyelesaian' => 'selesai',
                    'status_validasi' => 'valid',
                    'validator_id' => $admin->user_id,
                    'validated_at' => now(),
                ]
            );
            $this->buatAbsensi($jurnal2->id, $murids8B);
        }

        // 7. Buat Bahan Ajar Dummy
        ModulAjar::firstOrCreate(
            ['guru_id' => $guru1->id, 'nama_file' => 'Modul_Aljabar.pdf'],
            ['path_file' => 'dummy/modul_aljabar.pdf']
        );
        ModulAjar::firstOrCreate(
            ['guru_id' => $guru2->id, 'nama_file' => 'Modul_Pencernaan.pdf'],
            ['path_file' => 'dummy/modul_pencernaan.pdf']
        );

        // 8. Buat Kalender Akademik Aktif
        KalenderAkademik::firstOrCreate(
            ['tahun_ajaran' => '2026/2027', 'semester' => 'Ganjil'],
            [
                'admin_id' => $admin->id,
                'tanggal_mulai' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'nama_file' => 'Kalender_Akademik_Dummy.pdf',
                'path_file' => 'dummy/kalender.pdf'
            ]
        );
    }

    private function buatAbsensi($journalId, $murids)
    {
        foreach ($murids as $index => $m) {
            $status = 'hadir';
            if ($index == 1) $status = 'sakit';
            if ($index == 2) $status = 'izin';
            
            Attendance::firstOrCreate(
                ['journal_id' => $journalId, 'murid_id' => $m->id],
                ['status_kehadiran' => $status]
            );
        }
    }
}