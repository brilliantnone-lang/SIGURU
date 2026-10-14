<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['nama_mata_pelajaran'];

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}