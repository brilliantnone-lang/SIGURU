<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\KepalaSekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'nip_admin' => '198001012005011001',
        ]);

        // Kepsek default
        $kepsek = User::create([
            'name' => 'Kepala Sekolah',
            'username' => 'kepsek',
            'password' => Hash::make('kepsek123'),
            'role' => 'kepsek',
        ]);

        KepalaSekolah::create([
            'user_id' => $kepsek->id,
            'nip_kepsek' => '197501012000011001',
        ]);
    }
}