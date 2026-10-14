<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';
    protected $fillable = [
        'nis',
        'kelas_id',
        'nama_siswa',
        'jenis_kelamin',
        'tanggal_lahir',
        'nomor_telepon',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}