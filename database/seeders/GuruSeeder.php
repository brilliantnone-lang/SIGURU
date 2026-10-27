<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Guru default
        $guru = User::firstOrCreate(
            ['username' => 'guru'],
            [
                'name' => 'Guru Contoh',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ]
        );

        Guru::firstOrCreate(
            ['user_id' => $guru->id],
            [
                'mata_pelajaran_id' => 1, // Pastikan MataPelajaranSeeder dijalankan dulu
                'nip_guru' => '198801012000011001',
                'nomor_telepon' => null,
            ]
        );
    }
}