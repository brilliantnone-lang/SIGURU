<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'IPS',
            'PKn',
            'Seni Budaya',
            'PJOK',
            'Informatika',
            'Bahasa Banjar',
        ];

        foreach ($mapel as $nama) {
            MataPelajaran::create(['nama_mata_pelajaran' => $nama]);
        }
    }
}