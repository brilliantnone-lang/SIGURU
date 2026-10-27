<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverJurnal extends Model
{
    protected $table = 'cover_jurnal';

    protected $fillable = [
        'admin_id',
        'nama_sekolah',
        'npsn',
        'alamat',
        'logo',
        'tahun_ajaran',
        'semester',
        'nama_kepsek',
        'nip_kepsek',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function jurnal()
    {
        return $this->hasMany(Journal::class);
    }
}