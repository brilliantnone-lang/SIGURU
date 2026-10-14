<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'jam_mulai_ke',
        'jam_selesai_ke',
        'hari',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function journal()
    {
        return $this->hasMany(Journal::class);
    }

    // Helper: jumlah jam dalam jadwal ini
    public function getJumlahJamAttribute(): int
    {
        return $this->jam_selesai_ke - $this->jam_mulai_ke + 1;
    }
}