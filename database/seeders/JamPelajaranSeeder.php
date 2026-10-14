<?php

namespace Database\Seeders;

use App\Models\JamPelajaran;
use Illuminate\Database\Seeder;

class JamPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $jam = [
            ['jam_ke' => 1, 'rentang_waktu' => '07:30 - 08:10'],
            ['jam_ke' => 2, 'rentang_waktu' => '08:10 - 08:50'],
            ['jam_ke' => 3, 'rentang_waktu' => '08:50 - 09:30'],
            ['jam_ke' => 4, 'rentang_waktu' => '09:30 - 10:10'],
            ['jam_ke' => 5, 'rentang_waktu' => '10:10 - 10:50'],
            ['jam_ke' => 6, 'rentang_waktu' => '10:50 - 11:30'],
            ['jam_ke' => 7, 'rentang_waktu' => '11:30 - 12:10'],
            ['jam_ke' => 8, 'rentang_waktu' => '12:10 - 12:50'],
        ];

        foreach ($jam as $j) {
            JamPelajaran::create($j);
        }
    }
}