<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            ['nama_kelas' => 'VII A', 'kapasitas' => 32],
            ['nama_kelas' => 'VII B', 'kapasitas' => 32],
            ['nama_kelas' => 'VIII A', 'kapasitas' => 32],
            ['nama_kelas' => 'VIII B', 'kapasitas' => 32],
            ['nama_kelas' => 'IX A', 'kapasitas' => 32],
            ['nama_kelas' => 'IX B', 'kapasitas' => 32],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}