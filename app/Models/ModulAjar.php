<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulAjar extends Model
{
    protected $table = 'modul_ajar';
    protected $fillable = ['guru_id', 'nama_file', 'path_file'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}