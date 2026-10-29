<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulAjar extends Model
{
    protected $table = 'modul_ajar';
    protected $fillable = ['guru_id', 'kelas_id', 'nama_file', 'path_file', 'catatan'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
