<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'logo',
        'tahun_ajaran',
        'semester',
        'nama_kepsek',
        'nip_kepsek',
    ];

    public static function getSetting()
    {
        return self::first();
    }
}