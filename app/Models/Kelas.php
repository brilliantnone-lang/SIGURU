<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'kapasitas'];

    public function murid()
    {
        return $this->hasMany(Murid::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function journal()
    {
        return $this->hasMany(Journal::class);
    }
}