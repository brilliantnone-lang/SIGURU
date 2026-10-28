<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Data Master (Tidak butuh FK)
            MataPelajaranSeeder::class,
            KelasSeeder::class,
            JamPelajaranSeeder::class,

            // 2. Data User (Butuh tabel users)
            UserSeeder::class,
            GuruSeeder::class, // Sekarang dipanggil setelah mapel & user siap
            DummyDataSeeder::class,
        ]);
    }
}