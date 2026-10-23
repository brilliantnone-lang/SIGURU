<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        Admin::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'nip_admin' => '198001012005011001',
            ]
        );

        // Kepala Sekolah default
        $kepsek = User::firstOrCreate(
            ['username' => 'kepsek'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('kepsek123'),
                'role' => 'kepsek',
            ]
        );

        KepalaSekolah::firstOrCreate(
            ['user_id' => $kepsek->id],
            [
                'nip_kepsek' => '197501012000011001',
            ]
        );


        // Guru default
        $guru = User::firstOrCreate(
            ['username' => 'guru'],
            [
                'name' => 'Guru',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ]
        );

        Guru::firstOrCreate(
            ['user_id' => $guru->id],
            [
                'mata_pelajaran_id' => 1,
                'nip_guru' => '198801012000011001',
                'nomor_telepon' => null,
            ]
        );

    }
}
