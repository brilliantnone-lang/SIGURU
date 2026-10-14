<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = [
        'user_id',
        'mata_pelajaran_id',
        'nip_guru',
        'nomor_telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function modulAjar()
    {
        return $this->hasMany(ModulAjar::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function journal()
    {
        return $this->hasMany(Journal::class, 'guru_id');
    }

    public function journalPendamping()
    {
        return $this->hasMany(Journal::class, 'guru_pendamping_id');
    }
}